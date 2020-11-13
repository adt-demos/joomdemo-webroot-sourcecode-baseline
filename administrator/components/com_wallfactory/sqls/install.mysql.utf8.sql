DROP TABLE IF EXISTS `#__com_wallfactory_bookmarks`;
CREATE TABLE `#__com_wallfactory_bookmarks`
(
  `id`        int(11) NOT NULL AUTO_INCREMENT,
  `title`     varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link`      mediumtext COLLATE utf8mb4_unicode_ci   NOT NULL,
  `thumbnail` varchar(20) COLLATE utf8mb4_unicode_ci  NOT NULL DEFAULT '',
  `published` tinyint(1) NOT NULL,
  `ordering`  int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `#__com_wallfactory_comments`;
CREATE TABLE `#__com_wallfactory_comments`
(
  `id`           int(11) NOT NULL AUTO_INCREMENT,
  `post_id`      int(11) NOT NULL,
  `user_id`      int(11) NOT NULL,
  `content`      mediumtext COLLATE utf8mb4_unicode_ci   NOT NULL,
  `author_name`  varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `published`    tinyint(1) NOT NULL,
  `updated_at`   datetime                                NOT NULL,
  `created_at`   datetime                                NOT NULL,
  PRIMARY KEY (`id`),
  KEY            `published_post_id` (`published`,`post_id`),
  KEY            `post_id` (`post_id`),
  KEY            `created_at` (`created_at`),
  KEY            `user_id` (`user_id`),
  KEY            `published` (`published`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `#__com_wallfactory_emoticons`;
CREATE TABLE `#__com_wallfactory_emoticons`
(
  `id`        int(11) NOT NULL AUTO_INCREMENT,
  `title`     varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename`  varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordering`  int(11) NOT NULL,
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `#__com_wallfactory_likes`;
CREATE TABLE `#__com_wallfactory_likes`
(
  `id`            int(11) NOT NULL AUTO_INCREMENT,
  `user_id`       int(11) NOT NULL,
  `resource_id`   int(11) NOT NULL,
  `resource_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at`    datetime                               NOT NULL,
  PRIMARY KEY (`id`),
  KEY             `resource_type_resource_id` (`resource_type`,`resource_id`),
  KEY             `user_id_resource_id` (`user_id`,`resource_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `#__com_wallfactory_media`;
CREATE TABLE `#__com_wallfactory_media`
(
  `id`         int(11) NOT NULL AUTO_INCREMENT,
  `post_id`    int(11) NOT NULL,
  `media_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `media_id`   int(11) NOT NULL,
  `ordering`   int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY          `post_id` (`post_id`),
  KEY          `media_type` (`media_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `#__com_wallfactory_media_audio`;
CREATE TABLE `#__com_wallfactory_media_audio`
(
  `id`          int(11) NOT NULL AUTO_INCREMENT,
  `post_id`     int(11) NOT NULL,
  `title`       varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci   NOT NULL,
  `path`        varchar(15) COLLATE utf8mb4_unicode_ci  NOT NULL,
  `filename`    varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `#__com_wallfactory_media_files`;
CREATE TABLE `#__com_wallfactory_media_files`
(
  `id`          int(11) NOT NULL AUTO_INCREMENT,
  `post_id`     int(11) NOT NULL,
  `title`       varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci   NOT NULL,
  `path`        varchar(15) COLLATE utf8mb4_unicode_ci  NOT NULL,
  `filename`    varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `#__com_wallfactory_media_links`;
CREATE TABLE `#__com_wallfactory_media_links`
(
  `id`          int(11) NOT NULL AUTO_INCREMENT,
  `post_id`     int(11) NOT NULL,
  `url`         varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title`       varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci         NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `#__com_wallfactory_media_photos`;
CREATE TABLE `#__com_wallfactory_media_photos`
(
  `id`          int(11) NOT NULL AUTO_INCREMENT,
  `post_id`     int(11) NOT NULL,
  `title`       varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci   NOT NULL,
  `path`        varchar(15) COLLATE utf8mb4_unicode_ci  NOT NULL,
  `params`      mediumtext COLLATE utf8mb4_unicode_ci   NOT NULL,
  `filename`    varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `#__com_wallfactory_media_videos`;
CREATE TABLE `#__com_wallfactory_media_videos`
(
  `id`          int(11) NOT NULL AUTO_INCREMENT,
  `post_id`     int(11) NOT NULL,
  `url`         varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `player`      text COLLATE utf8mb4_unicode_ci         NOT NULL,
  `title`       varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci         NOT NULL,
  `thumbnail`   text COLLATE utf8mb4_unicode_ci         NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `#__com_wallfactory_notifications`;
CREATE TABLE `#__com_wallfactory_notifications`
(
  `id`        int(11) NOT NULL AUTO_INCREMENT,
  `type`      varchar(50) COLLATE utf8mb4_unicode_ci  NOT NULL,
  `subject`   varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body`      mediumtext COLLATE utf8mb4_unicode_ci   NOT NULL,
  `language`  char(7) COLLATE utf8mb4_unicode_ci      NOT NULL,
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `#__com_wallfactory_posts`;
CREATE TABLE `#__com_wallfactory_posts`
(
  `id`           int(11) NOT NULL AUTO_INCREMENT,
  `user_id`      int(11) NOT NULL,
  `to_user_id`   int(11) NOT NULL,
  `content`      mediumtext COLLATE utf8mb4_unicode_ci   NOT NULL,
  `author_name`  varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `published`    tinyint(1) NOT NULL,
  `created_at`   datetime                                NOT NULL,
  PRIMARY KEY (`id`),
  KEY            `created_at` (`created_at`),
  KEY            `published_to_user_id` (`published`,`to_user_id`),
  KEY            `published` (`published`),
  KEY            `user_id` (`user_id`),
  KEY            `to_user_id` (`to_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `#__com_wallfactory_profiles`;
CREATE TABLE `#__com_wallfactory_profiles`
(
  `user_id`       int(11) NOT NULL,
  `name`          varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description`   mediumtext COLLATE utf8mb4_unicode_ci   NOT NULL,
  `avatar_source` varchar(20) COLLATE utf8mb4_unicode_ci  NOT NULL,
  `thumbnail`     varchar(50) COLLATE utf8mb4_unicode_ci  NOT NULL,
  `notifications` mediumtext COLLATE utf8mb4_unicode_ci   NOT NULL,
  `created_at`    datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY             `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `#__com_wallfactory_reports`;
CREATE TABLE `#__com_wallfactory_reports`
(
  `id`               int(11) NOT NULL AUTO_INCREMENT,
  `user_id`          int(11) NOT NULL,
  `resource_id`      int(11) NOT NULL,
  `resource_type`    varchar(50) COLLATE utf8mb4_unicode_ci  NOT NULL,
  `resource_user_id` int(11) NOT NULL,
  `resource_title`   varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resource_excerpt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment`          mediumtext COLLATE utf8mb4_unicode_ci   NOT NULL,
  `resolved`         tinyint(1) NOT NULL,
  `updated_at`       datetime                                NOT NULL,
  `created_at`       datetime                                NOT NULL,
  PRIMARY KEY (`id`),
  KEY                `resolved` (`resolved`),
  KEY                `created_at` (`created_at`),
  KEY                `resource_type` (`resource_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `#__com_wallfactory_subscriptions`;
CREATE TABLE `#__com_wallfactory_subscriptions`
(
  `id`            int(11) NOT NULL AUTO_INCREMENT,
  `subscriber_id` int(11) NOT NULL,
  `user_id`       int(11) NOT NULL,
  `notification`  tinyint(1) NOT NULL,
  `created_at`    datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY             `subscriber_id` (`subscriber_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;


INSERT INTO `#__com_wallfactory_bookmarks` (`id`, `title`, `link`, `thumbnail`, `published`, `ordering`)
VALUES
(1, 'Delicious', 'http://del.icio.us/post?url={{ url }}&title={{ title }}', '1.png', 1, 1),
(2, 'Digg', 'http://digg.com/submit?phase=2&url={{ url }}&title={{ title }}', '2.png', 1, 2),
(3, 'Google Bookmarks', 'http://www.google.com/bookmarks/mark?op=add&bkmk={{ url }}&title={{ title }}', '3.png', 1, 3),
(4, 'Facebook', 'http://www.facebook.com/share.php?u={{ url }}&t={{ title }}', '4.png', 1, 4),
(5, 'Technorati', 'http://technorati.com/faves/?add={{ url }}&title={{ title }}', '5.png', 1, 5),
(6, 'Stumbleupon', 'http://www.stumbleupon.com/submit?url={{ url }}&title={{ title }}', '6.png', 1, 6),
(7, 'Reddit', 'http://reddit.com/submit?url={{ url }}&title={{ title }}', '7.png', 1, 7),
(8, 'My Space', 'http://www.myspace.com/Modules/PostTo/Pages/?u={{ url }}&t={{ title }}', '8.png', 1, 8),
(9, 'Amazon', 'http://www.amazon.com/wishlist/add?u={{ url }}&t={{ title }}', '9.png', 1, 9),
(10, 'Twitter', 'http://twitter.com/home?status={{ title }}%3A+{{ url }}', '10.png', 1, 10),
(11, 'Bebo', 'http://bebo.com/c/share?Url={{ url }}&Title={{ title }}', '11.png', 1, 11),
(12, 'Linkedin', 'http://www.linkedin.com/shareArticle?mini=true&url={{ url }}&title={{ title }}', '12.png', 1, 12),
(13, 'Mixx', 'http://www.mixx.com/submit?page_url={{ url }}', '13.png', 1, 13),
(14, 'Netvibes', 'http://netvibes.com/share?url={{ url }}&title={{ title }}', '14.png', 1, 14),
(15, 'Newsvine', 'http://www.newsvine.com/_tools/seed&save?u={{ url }}&h={{ title }}', '15.png', 1, 15),
(16, 'Tumblr', 'http://www.tumblr.com/share?v=3&u={{ url }}&t={{ title }}&s=', '16.png', 1, 16),
(17, 'Virb', 'http://virb.com/share?external&v=2&url={{ url }}&title={{ title }}', '17.png', 1, 17),
(18, 'Yahoo Mail', 'http://compose.mail.yahoo.com/?To=&Subject={{ title }}&body={{ bodytext }}', '18.png', 1, 18);

INSERT INTO `#__com_wallfactory_emoticons` (`id`, `title`, `filename`, `ordering`, `published`)
VALUES
  (1, 'Angry 1', 'angry-1.png', 0, 1),
  (2, 'Angry', 'angry.png', 1, 1),
  (3, 'Bored 1', 'bored-1.png', 2, 1),
  (4, 'Bored 2', 'bored-2.png', 3, 1),
  (5, 'Bored', 'bored.png', 4, 1),
  (6, 'Confused 1', 'confused-1.png', 5, 1),
  (7, 'Confused', 'confused.png', 6, 1),
  (8, 'Crying 1', 'crying-1.png', 7, 1),
  (9, 'Crying', 'crying.png', 8, 1),
  (10, 'Embarrassed', 'embarrassed.png', 9, 1),
  (11, 'Emoticons', 'emoticons.png', 10, 1),
  (12, 'Happy 1', 'happy-1.png', 11, 1),
  (13, 'Happy 2', 'happy-2.png', 12, 1),
  (14, 'Happy 3', 'happy-3.png', 13, 1),
  (15, 'Happy 4', 'happy-4.png', 14, 1),
  (16, 'Happy', 'happy.png', 15, 1),
  (17, 'Ill', 'ill.png', 16, 1),
  (18, 'In love', 'in-love.png', 17, 1),
  (19, 'Kissing', 'kissing.png', 18, 1),
  (20, 'Mad', 'mad.png', 19, 1),
  (21, 'Nerd', 'nerd.png', 20, 1),
  (22, 'Ninja', 'ninja.png', 21, 1),
  (23, 'Quiet', 'quiet.png', 22, 1),
  (24, 'Sad', 'sad.png', 23, 1),
  (25, 'Secret', 'secret.png', 24, 1),
  (26, 'Smart', 'smart.png', 25, 1),
  (27, 'Smile', 'smile.png', 26, 1),
  (28, 'Smiling', 'smiling.png', 27, 1),
  (29, 'Surprised 1', 'surprised-1.png', 28, 1),
  (30, 'Surprised', 'surprised.png', 29, 1),
  (31, 'Suspicious 1', 'suspicious-1.png', 30, 1),
  (32, 'Suspicious', 'suspicious.png', 31, 1),
  (33, 'Tongue out 1', 'tongue-out-1.png', 32, 1),
  (34, 'Tongue out', 'tongue-out.png', 33, 1),
  (35, 'Unhappy', 'unhappy.png', 34, 1),
  (36, 'Wink', 'wink.png', 35, 1);
