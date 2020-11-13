DROP TABLE IF EXISTS `#__com_wallfactory_emoticons`;
CREATE TABLE `#__com_wallfactory_emoticons`
(
  `id`        int(11) NOT NULL AUTO_INCREMENT,
  `title`     varchar(255) NOT NULL,
  `filename`  varchar(255) NOT NULL,
  `ordering`  int(11) NOT NULL,
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
