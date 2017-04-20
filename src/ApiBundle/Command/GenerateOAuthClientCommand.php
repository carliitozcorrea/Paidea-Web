<?php

namespace ApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use OAuth2\OAuth2;

class GenerateOAuthClientCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('generate:oauth:client')
            ->setDescription('Generate OAuth2 Client')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Continue with this action?', false);

        if (!$helper->ask($input, $output, $question)) {
            return;
        }

        $clientManager = $this->getContainer()->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        $client->setAllowedGrantTypes(array(OAuth2::GRANT_TYPE_USER_CREDENTIALS, OAuth2::GRANT_TYPE_REFRESH_TOKEN));
        $clientManager->updateClient($client);

        $output->writeln(sprintf('Command result Id:<info>%s</info> Secret:<info>%s</info>', $client->getPublicId(), $client->getSecret()));
    }

}