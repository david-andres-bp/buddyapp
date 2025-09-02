-- ConnectSphere Theme Schema
--
-- This script contains the necessary SQL statements to create the database tables
-- required for the ConnectSphere theme.
--
-- It assumes that you have already run the migrations for CodeIgniter Shield,
-- which creates the `users` table and other related authentication tables.

-- Add bio column to users table
ALTER TABLE `users` ADD `bio` TEXT NULL;

-- Create posts table
CREATE TABLE `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `content` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Create followers table
CREATE TABLE `followers` (
  `follower_id` int(11) unsigned NOT NULL,
  `followed_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`follower_id`, `followed_id`),
  KEY `followed_id_foreign_idx` (`followed_id`),
  CONSTRAINT `followers_followed_id_foreign` FOREIGN KEY (`followed_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `followers_follower_id_foreign` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Create notifications table
CREATE TABLE `notifications` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `type` varchar(255) NOT NULL,
  `data` json DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Create threads table
CREATE TABLE `threads` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- Create messages table
CREATE TABLE `messages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `thread_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `content` text,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `thread_id` (`thread_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `messages_thread_id_foreign` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Create thread_participants table
CREATE TABLE `thread_participants` (
  `thread_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`thread_id`, `user_id`),
  KEY `user_id_foreign_idx` (`user_id`),
  CONSTRAINT `thread_participants_thread_id_foreign` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `thread_participants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Create pinned_profiles table
CREATE TABLE `pinned_profiles` (
  `user_id` int(11) unsigned NOT NULL,
  `pinned_user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`, `pinned_user_id`),
  KEY `pinned_user_id_foreign_idx` (`pinned_user_id`),
  CONSTRAINT `pinned_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pinned_profiles_pinned_user_id_foreign` FOREIGN KEY (`pinned_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Create likes table
CREATE TABLE `likes` (
  `user_id` int(11) unsigned NOT NULL,
  `post_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`, `post_id`),
  KEY `post_id_foreign_idx` (`post_id`),
  CONSTRAINT `likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `likes_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Create comments table
CREATE TABLE `comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `content` text,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Create media table
CREATE TABLE `media` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `post_id` int(11) unsigned DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `media_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `media_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);
