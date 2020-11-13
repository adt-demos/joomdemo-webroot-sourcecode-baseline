ALTER TABLE `#__com_wallfactory_bookmarks`
  ENGINE='InnoDB';

ALTER TABLE `#__com_wallfactory_comments`
  ENGINE='InnoDB';

ALTER TABLE `#__com_wallfactory_emoticons`
  CHANGE `title` `title` varchar (255) COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `id`,
  CHANGE `filename` `filename` varchar (255) COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `title`,
  COLLATE 'utf8mb4_unicode_ci',
  ENGINE='InnoDB';

ALTER TABLE `#__com_wallfactory_likes`
  ENGINE='InnoDB';

ALTER TABLE `#__com_wallfactory_media`
  CHANGE `media_type` `media_type` varchar (20) COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `post_id`,
  ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `#__com_wallfactory_media_audio`
  CHANGE `title` `title` varchar (255) COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `post_id`,
  CHANGE `description` `description` mediumtext COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `title`,
  CHANGE `path` `path` varchar (15) COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `description`,
  CHANGE `filename` `filename` varchar (255) COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `path`,
  ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `#__com_wallfactory_media_files`
  CHANGE `title` `title` varchar (255) COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `post_id`,
  CHANGE `description` `description` mediumtext COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `title`,
  CHANGE `path` `path` varchar (15) COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `description`,
  CHANGE `filename` `filename` varchar (255) COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `path`,
  ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `#__com_wallfactory_media_links`
  CHANGE `url` `url` varchar (255) COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `post_id`,
  CHANGE `title` `title` varchar (255) COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `url`,
  CHANGE `description` `description` text COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `title`,
  ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `#__com_wallfactory_media_photos`
  CHANGE `title` `title` varchar (255) COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `post_id`,
  CHANGE `description` `description` mediumtext COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `title`,
  CHANGE `path` `path` varchar (15) COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `description`,
  CHANGE `filename` `filename` varchar (255) COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `path`,
  ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `#__com_wallfactory_media_videos`
  CHANGE `url` `url` varchar (255) COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `post_id`,
  CHANGE `player` `player` text COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `url`,
  CHANGE `title` `title` varchar (255) COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `player`,
  CHANGE `description` `description` text COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `title`,
  CHANGE `thumbnail` `thumbnail` text COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `description`,
  ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `#__com_wallfactory_notifications`
  ENGINE='InnoDB';

ALTER TABLE `#__com_wallfactory_posts`
  ENGINE='InnoDB';

ALTER TABLE `#__com_wallfactory_profiles`
  ENGINE='InnoDB';

ALTER TABLE `#__com_wallfactory_reports`
  ENGINE='InnoDB';

ALTER TABLE `#__com_wallfactory_subscriptions`
  ENGINE='InnoDB';
