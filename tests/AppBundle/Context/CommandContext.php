<?php
namespace tests\AppBundle\Context;
 
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Exception;
use AppBundle\Command\ImportCSVCommand;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\HttpKernel\KernelInterface;
 
class CommandContext implements KernelAwareContext
{
    /** @var KernelInterface */
    private $kernel;
    /** @var Application */
    private $application;
    /** @var Command */
    private $command;
    /** @var CommandTester */
    private $commandTester;
    /** @var string */
    private $commandException;
    /** @var array */
    private $options;
 
    /**
     * @param KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

	/**
     * @Given a shell console
     */
    public function aShellConsole(){}

 /**
     * @When I execute the :commandName command with a :optionName option and :param parameter
     */
    public function iExecuteTheCommandWithAOptionAndParameter($commandName, $optionName, $param)
    {
    	$this->setApplication();
        $this->addCommand(new ImportCSVCommand());
        $this->setCommand( $commandName );
 
        try {
            $this->getTester($this->command)->execute([ $optionName => $param ]);
        } catch (Exception $exception) {
            $path = explode('\\', get_class($exception));
            //$this->commandException = array_pop($path);
            $this->commandException = $exception->getMessage();
        }
    }
 
    /**
     * @param string $expectedOutput
     *
     * @Then /^the command output should be "([^"]*)"$/
     */
    public function theCommandOutputShouldBe($expectedOutput)
    {
        $output = trim($this->commandTester->getDisplay());
        if ($output != $expectedOutput) {
            throw new LogicException(sprintf('Current output is: [%s]', $output));
        }
    }

     /**
     * @When the file :filename exists
     */
    public function theFileExists($filename)
    {
    	$file = $this->getFullPath( $filename );
    	if (!file_exists($file)) {
    		throw new LogicException(sprintf('This file does not exist: [%s]', $file));
    	}
    }

    /**
     * @When the file :filename is a CSV file
     */
    public function theFileIsACsvFile($filename)
    {
    	$file = $this->getFullPath( $filename );
    }

    /**
     * @When the file :filename does not exists
     */
    public function theFileDoesNotExists($filename)
    {
    	$file = $this->getFullPath( $filename );
    	if (file_exists($file)) {
    		throw new LogicException(sprintf('This file does not exist: [%s]', $file));
    	}
    }

    /**
     * @When the file :filename is not a valid CSV
     */
    public function theFileIsNotAValidCsv($filename)
    {
    	$file = $this->getFullPath( $filename );
    }

    /**
     * @Then the command CommandException should be :expectedException
     */
    public function theCommandCommandexceptionShouldBe($expectedException)
    {
    	if ($this->commandException != $expectedException) {
            throw new LogicException(sprintf('Current exception is: [%s]', $this->commandException));
        }
    }

    /**
     * @Then the command CommandException should be :expectedException:filename
     */
    public function theCommandCommandexceptionShouldBe2($expectedException, $filename)
    {
        $expectedException .= $this->getFullPath( $filename );
        if ($this->commandException != $expectedException) {
            throw new LogicException(sprintf('Current exception is: [%s]', $this->commandException));
        }
    }

    private function getFullPath( $filename )
    {
		return $this->kernel->getRootDir() . '/../storage/' . $filename;
    }
 
    private function setApplication()
    {
        $this->application = new Application($this->kernel);
    }
 
    private function addCommand(Command $command)
    {
        $this->application->add($command);
    }
 
    private function setCommand($commandName)
    {
        $this->command = $this->application->find($commandName);
    }
 
    private function setOptions(TableNode $tableNode)
    {
        $options = [];
        foreach ($tableNode->getRowsHash() as $key => $value) {
            $options[$key] = $value;
        }
 
        $this->options = $options;
    }
 
    private function getTester(Command $command)
    {
        $this->commandTester = new CommandTester($command);
 
        return $this->commandTester;
    }

    /** @AfterScenario */
    public function cleanDB(AfterScenarioScope $event)
    {
        $em = $this->kernel->getContainer()->get('doctrine')->getManager();
        $query = $em->createQuery('DELETE FROM AppBundle:Transaction');
        $query->execute(); 
    }
}