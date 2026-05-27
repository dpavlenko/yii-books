<?php

use yii\db\Migration;

class m260527_200516_initial extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("
            SET NAMES utf8;
        ")->execute();


        $this->db->createCommand("
            CREATE TABLE `author` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `name` varchar(255) NOT NULL,
              `surname` varchar(255) NOT NULL,
              `second_name` varchar(255) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ")->execute();

        $this->db->createCommand("
            CREATE TABLE `book` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `name` varchar(255) NOT NULL,
              `year` year(4) NOT NULL,
              `description` text NOT NULL,
              `isbn` varchar(255) NOT NULL,
              `front_page` varchar(1024) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ")->execute();
        $this->db->createCommand("
            CREATE TABLE `book_author` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `book_id` int(10) unsigned NOT NULL,
              `author_id` int(10) unsigned NOT NULL,
              PRIMARY KEY (`id`),
              KEY `book_id` (`book_id`),
              KEY `author_id` (`author_id`),
              CONSTRAINT `book_author_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`),
              CONSTRAINT `book_author_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ")->execute();

        $this->db->createCommand("
            CREATE TABLE `user` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `username` varchar(255) NOT NULL,
              `auth_key` varchar(255) NOT NULL,
              `password_hash` varchar(1024) NOT NULL,
              `password_reset_token` varchar(1024) NOT NULL,
              `email` varchar(255) NOT NULL,
              `status` int(11) NOT NULL,
              `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
              `updated_at` timestamp NULL DEFAULT NULL,
              `verification_token` varchar(1024) NOT NULL,
              `access_token` varchar(1024) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ")->execute();

        $this->db->createCommand("
            CREATE TABLE `subscription` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `user_id` int(10) unsigned NOT NULL,
              `phone` varchar(20) NOT NULL,
              PRIMARY KEY (`id`),
              KEY `user_id` (`user_id`),
              CONSTRAINT `subscription_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ")->execute();

        $this->db->createCommand("
            INSERT INTO `author` (`id`, `name`, `surname`, `second_name`) VALUES
            (1,	'Джоан',	'',	'Роулинг'),
            (2,	'Антуан',	'',	'де Сент-Экзюпери'),
            (3,	'Джордж',	'',	'Оруэлл'),
            (4,	'Михаил',	'Афанасьевич',	'Булгаков'),
            (5,	'Test_author5',	'Test_author5',	'Test_author5'),
            (6,	'Test_author6',	'Test_author6',	'Test_author6'),
            (7,	'Test_author7',	'Test_author7',	'Test_author7'),
            (8,	'Test_author8',	'Test_author8',	'Test_author8'),
            (9,	'Test_author9',	'Test_author9',	'Test_author9'),
            (10,	'Test_author10',	'Test_author10',	'Test_author10'),
            (11,	'Test_author11',	'Test_author11',	'Test_author11'),
            (12,	'Test_author12',	'Test_author12',	'Test_author12');
        ")->execute();

        $this->db->createCommand("
            INSERT INTO `book` (`id`, `name`, `year`, `description`, `isbn`, `front_page`) VALUES
            (2,	'Гарри Поттер и философский камень',	'2000',	'test',	'ISBN: 978-5-389-07505-4',	''),
            (3,	'Маленький принц',	'1950',	'test',	'978-5-699-69335-5',	''),
            (4,	'1984',	'1965',	'test',	'978-5-17-080115-7',	''),
            (5,	'Мастер и Маргарита',	'1935',	'test',	'978-5-17-099497-2',	''),
            (6,	'Cборник лучших произведений',	'2024',	'test',	'978-5-389-09662-2',	''),
            (7,	'Иван Васильевич',	'2015',	'test',	'978-5-389-10474-7',	''),
            (8,	'Гарри Поттер и Орден Феникса',	'2020',	'test',	'978-5-389-12054-9',	''),
            (9,	'История России : учебник',	'2024',	'Смирнов, А. В. История России : учебник / А. В. Смирнов, Е. П. Петров. – Санкт-Петербург : Питер, 2024. – 412 с',	'978-5-9988-1234-5',	'');
        ")->execute();

        $this->db->createCommand("
            INSERT INTO `book_author` (`id`, `book_id`, `author_id`) VALUES
            (36,	2,	1),
            (38,	3,	2),
            (39,	4,	3),
            (40,	5,	4),
            (41,	6,	4),
            (42,	7,	4),
            (43,	8,	1),
            (44,	9,	5);
        ")->execute();

        $this->db->createCommand("
            INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`, `access_token`) VALUES
            (1,	'admin',	'test100key',	'\$2y$\13\$gYAywKSkhfZDq9FLNdm7buKnvlRxDexf5xipSMAxQPDUxpaptmZJu',	'',	'',	10,	'2026-05-27 18:26:17',	NULL,	'',	'100-token'),
            (2,	'demo',	'test101key',	'\$2y\$13\$alRLq1PGVMlGYwS/Y3iy3ewQns1Z8ol8Iq6Zb5k7ZwEhblA1aL29y',	'',	'',	10,	NULL,	NULL,	'',	'101-token');
            ")->execute();

        $this->db->createCommand("
            INSERT INTO `subscription` (`id`, `user_id`, `phone`) VALUES
            (1,	1,	'79101365540');
        ")->execute();

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m260527_200516_initial cannot be reverted.\n";

        return false;
    }
}
