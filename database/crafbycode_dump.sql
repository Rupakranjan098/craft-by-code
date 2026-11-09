-- MySQL dump 10.13  Distrib 9.2.0, for macos15.2 (arm64)
--
-- Host: 127.0.0.1    Database: crafbycode
-- ------------------------------------------------------
-- Server version	9.2.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `about_contents`
--

DROP TABLE IF EXISTS `about_contents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `about_contents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `section_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `data` json DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `about_contents`
--

LOCK TABLES `about_contents` WRITE;
/*!40000 ALTER TABLE `about_contents` DISABLE KEYS */;
INSERT INTO `about_contents` VALUES (1,'intro','Transforming Ideas Into World-Class Digital Solutions','About UpPage Technology','Founded with a passion for software craftsmanship, UpPage Technology empowers startups and enterprises with high-velocity digital solutions. We bridge the gap between creative visual design and complex technical architecture to engineer digital products that solve real-world problems and generate measurable ROI.',NULL,1,1,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(2,'story','Our Story: Born to Build Better','How We Started','UpPage Technology started as a tight-knit collective of seasoned engineers and product designers frustrated with bureaucratic agencies that overpromised and underdelivered. We resolved to construct an engineering firm centered on transparent communication, clean code craftsmanship, and relentless commitment to client success. Over the past 5+ years, we have grown into a trusted technology partner for startups, unicorns, and established businesses across North America, Europe, and Asia.',NULL,2,1,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(3,'mission_vision','Mission & Vision','Our Guiding Star','Our mission is to empower businesses with transformative software engineering and thoughtful design. Our vision is to be the premier global technology studio recognized for setting new standards in software reliability, elegant UX, and high-impact digital innovation.','{\"vision\": \"To be the world’s most trusted software partner for innovators who refuse to compromise on quality, security, or design.\", \"mission\": \"Empowering modern enterprises through bespoke digital solutions that drive operational agility, revenue growth, and unforgettable customer experiences.\"}',3,1,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(4,'values','Core Values That Drive Every Line of Code','What We Stand For','Our engineering culture is governed by four core pillars that guide every decision we make.','[{\"title\": \"Craftsmanship First\", \"description\": \"We don’t cut corners. Every database query, API endpoint, and UI component is architected for clean readability and long-term durability.\"}, {\"title\": \"Radical Transparency\", \"description\": \"Direct engineer-to-client communication with zero jargon. You always have full access to our git repositories and sprint progress.\"}, {\"title\": \"User-Centric Innovation\", \"description\": \"Technology serves humans. We build software that is intuitive, empathetic, and effortless to adopt.\"}, {\"title\": \"Speed Without Compromise\", \"description\": \"We launch high-velocity MVPs and features fast by leveraging modern tooling without sacrificing security or scalability.\"}]',4,1,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(5,'process','Our 5-Step Development Process','How We Work','A battle-tested agile methodology delivering predictable outcomes from day one.','[{\"step\": \"01\", \"title\": \"Discovery & Blueprinting\", \"description\": \"We deep-dive into your business goals, target audience, technical constraints, and deliver an actionable architecture roadmap.\"}, {\"step\": \"02\", \"title\": \"UI/UX Prototyping\", \"description\": \"Our designers create interactive Figma prototypes, conducting user flow validations before a single line of backend code is written.\"}, {\"step\": \"03\", \"title\": \"Agile Sprint Development\", \"description\": \"We build in iterative two-week sprints with automated CI/CD pipelines, allowing you to preview live staging builds continuously.\"}, {\"step\": \"04\", \"title\": \"Rigorous QA & Security Audit\", \"description\": \"Comprehensive automated unit testing, end-to-end browser tests, load testing, and security vulnerability patching.\"}, {\"step\": \"05\", \"title\": \"Deployment & 24/7 SLA Support\", \"description\": \"Zero-downtime production launch with proactive performance monitoring, cloud backups, and ongoing feature enhancement.\"}]',5,1,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(6,'why_trust','Why Fast-Growing Businesses Trust UpPage','The UpPage Advantage','We are not just contractors; we become an extension of your leadership team.','[{\"desc\": \"You own all code, repositories, design assets, and intellectual property from day one.\", \"highlight\": \"100% IP Ownership\"}, {\"desc\": \"We write strictly tested, standard-compliant PHP 8.4, Laravel, and modern JavaScript.\", \"highlight\": \"Zero Technical Debt\"}, {\"desc\": \"Your single point of contact keeps sprints synchronized with daily asynchronous updates.\", \"highlight\": \"Dedicated Project Managers\"}, {\"desc\": \"Cloud architecture ready to handle sudden traffic surges without downtime or cost spikes.\", \"highlight\": \"Scalable Infrastructure\"}]',6,1,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(7,'team','Meet Our Core Leadership','The People Behind the Code','Senior technologists, creative strategists, and solution architects passionate about your success.','[{\"bio\": \"12+ years building enterprise SaaS platforms and distributed cloud systems.\", \"name\": \"Alexander Hayes\", \"role\": \"Founder & Chief Technology Officer\", \"image\": \"/assets/images/team/team-1.jpg\"}, {\"bio\": \"Former design lead at Silicon Valley scale-ups with a focus on conversion UI.\", \"name\": \"Maya Lin\", \"role\": \"Head of Product & UX Design\", \"image\": \"/assets/images/team/team-2.jpg\"}, {\"bio\": \"Specializes in high-throughput Laravel APIs, database clustering, and security.\", \"name\": \"Marcus Vance\", \"role\": \"Lead Full-Stack Architect\", \"image\": \"/assets/images/team/team-3.jpg\"}, {\"bio\": \"Expert in LLM integration, automated agent workflows, and Kubernetes clusters.\", \"name\": \"Chloe Bennett\", \"role\": \"AI & Cloud Infrastructure Lead\", \"image\": \"/assets/images/team/team-4.jpg\"}]',7,1,'2026-11-06 22:55:05','2026-11-06 22:55:05');
/*!40000 ALTER TABLE `about_contents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attendances`
--

DROP TABLE IF EXISTS `attendances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attendances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `check_in` time DEFAULT NULL,
  `check_out` time DEFAULT NULL,
  `status` enum('present','late','half_day','absent','on_leave') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'present',
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `attendances_employee_id_date_unique` (`employee_id`,`date`),
  CONSTRAINT `attendances_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendances`
--

LOCK TABLES `attendances` WRITE;
/*!40000 ALTER TABLE `attendances` DISABLE KEYS */;
INSERT INTO `attendances` VALUES (1,1,'2026-11-07','09:02:00','18:05:00','present','On time, logged via biometric portal','2026-11-06 23:26:57','2026-11-06 23:26:57'),(2,2,'2026-11-07','09:14:00','18:00:00','present','Design sprint review','2026-11-06 23:26:57','2026-11-06 23:26:57'),(3,3,'2026-11-07','09:45:00','18:30:00','late','Late by 45 mins due to transit delay','2026-11-06 23:26:57','2026-11-06 23:26:57'),(4,4,'2026-11-07','08:55:00',NULL,'present','Server maintenance shift','2026-11-06 23:26:57','2026-11-06 23:26:57'),(5,5,'2026-11-07',NULL,NULL,'on_leave','Approved medical leave','2026-11-06 23:26:57','2026-11-06 23:26:57'),(6,6,'2026-11-07','09:05:00','18:10:00','present','Conducting candidate interviews','2026-11-06 23:26:57','2026-11-06 23:26:57');
/*!40000 ALTER TABLE `attendances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_posts`
--

DROP TABLE IF EXISTS `blog_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blog_posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '5 min read',
  `author_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UpPage Team',
  `published_at` timestamp NULL DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_posts_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_posts`
--

LOCK TABLES `blog_posts` WRITE;
/*!40000 ALTER TABLE `blog_posts` DISABLE KEYS */;
INSERT INTO `blog_posts` VALUES (1,'10 Best Practices for Clean Code in 2025','10-best-practices-for-clean-code','Development','/assets/images/blog/blog-code.jpg','Writing clean code is important for scalability, team speed, and long-term business success. Here are the 10 proven principles we practice every day.','<p>Writing clean, maintainable code is not just an aesthetic preference—it is a critical business strategy. In fast-moving technology companies, software that is difficult to understand or modify rapidly becomes technical debt that slows feature velocity to a crawl.</p><h3>1. Meaningful Names</h3><p>Choose names that reveal intent. A variable, function, or class name should tell you why it exists, what it does, and how it is used without requiring additional comments.</p><h3>2. Functions Should Do One Thing</h3><p>Functions should be small and do one thing only, and do it well. When a function executes multiple operations, extracting them into separate helper methods dramatically improves testability.</p><h3>3. Keep Controllers Thin</h3><p>In modern MVC architectures like Laravel, push business logic into Services, Actions, or Domain models. This preserves controller clarity and keeps endpoints reusable across API and web requests.</p>','5 min read','Alex Turner, Lead Architect','2026-11-01 22:55:05',1,1,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(2,'UI/UX Trends to Watch: Designing for Conversions','ui-ux-trends-to-watch','Design','/assets/images/blog/blog-design.jpg','Explore the latest UI/UX trends that are shaping the future of digital products, from spatial depth to hyper-personalized onboarding.','<p>User experience is experiencing a renaissance. As users interact with dozens of web and mobile apps daily, tolerance for confusing navigation or sluggish loading has dropped to zero.</p><h3>Micro-Interactions that Delight</h3><p>Subtle hover animations, button feedback ripples, and fluid tab transitions provide immediate psychological feedback, assuring users their inputs are registered.</p><h3>Minimalist Contrast & Accessibility</h3><p>Clean whitespace paired with bold typography and high-contrast electric accents ensures your message cuts through noise while complying with modern WCAG accessibility criteria.</p>','4 min read','Elena Rostova, Head of Design','2026-10-25 22:55:05',1,1,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(3,'How AI is Transforming Modern Businesses & Workflows','how-ai-is-transforming-businesses','AI','/assets/images/blog/blog-ai.jpg','AI automation tools are helping businesses save time, decrease overhead, and increase productivity tenfold. Discover how your team can leverage them.','<p>Artificial intelligence has transitioned from academic labs into daily business operations. Companies deploying automated workflows and generative assistants are discovering unprecedented productivity gains.</p><h3>Retrieval-Augmented Generation (RAG)</h3><p>By connecting Large Language Models directly to proprietary internal company wikis and support databases, organizations eliminate repetitive tier-1 support queries without risking data leaks.</p><h3>Automating Tedious Data Pipelines</h3><p>From automated PDF invoice parsing to real-time sentiment analysis on incoming client leads, AI removes friction from high-volume operations.</p>','6 min read','David Kim, AI Lead','2026-10-17 22:55:05',1,1,'2026-11-06 22:55:05','2026-11-06 22:55:05');
/*!40000 ALTER TABLE `blog_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('uppage-technology-cache-setting_brand_badge','s:42:\"TRUSTED BY STARTUPS & BUSINESSES WORLDWIDE\";',2109417027),('uppage-technology-cache-setting_brand_name','s:13:\"craft by code\";',2109417027),('uppage-technology-cache-setting_brand_sub_tagline','s:44:\"UI/UX • DEVELOPMENT • CREATIVE SOLUTIONS\";',2109417027),('uppage-technology-cache-setting_brand_tagline','s:38:\"CODE • DESIGN • SOLVE • INNOVATE\";',2109417027),('uppage-technology-cache-setting_contact_address','s:54:\"100 Innovation Way, Suite 400, San Francisco, CA 94105\";',2109417028),('uppage-technology-cache-setting_contact_email','s:17:\"hello@uppage.tech\";',2109417027),('uppage-technology-cache-setting_contact_hours','s:38:\"Monday - Friday: 9:00 AM - 6:00 PM EST\";',2109417048),('uppage-technology-cache-setting_contact_phone','s:17:\"+1 (555) 019-2834\";',2109417027),('uppage-technology-cache-setting_cta_button_text','s:15:\"Start a Project\";',2109417027),('uppage-technology-cache-setting_cta_button_url','s:8:\"/contact\";',2109417027),('uppage-technology-cache-setting_cta_subtitle','s:58:\"Have a project in mind? Let\'s turn your idea into reality.\";',2109417027),('uppage-technology-cache-setting_cta_title','s:38:\"Let\'s build something amazing together\";',2109417027),('uppage-technology-cache-setting_google_maps_url','s:295:\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.0863816568285!2d-122.39997232348573!3d37.78802271168436!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80858062828b8c73%3A0x6b63d91cf3241bc3!2sMarket%20St%2C%20San%20Francisco%2C%20CA!5e0!3m2!1sen!2sus!4v1710000000000!5m2!1sen!2sus\";',2109417048),('uppage-technology-cache-setting_hero_headline_1','s:10:\"WE DESIGN.\";',2109417027),('uppage-technology-cache-setting_hero_headline_2','s:8:\"WE CODE.\";',2109417027),('uppage-technology-cache-setting_hero_headline_gradient','s:12:\"WE INNOVATE.\";',2109417027),('uppage-technology-cache-setting_hero_subtitle','s:110:\"We build custom digital products, AI automation tools, and MVPs that help startups and businesses grow faster.\";',2109417027),('uppage-technology-cache-setting_logo_display_mode','s:15:\"horizontal_logo\";',2109417027),('uppage-technology-cache-setting_meta_description_default','s:126:\"UpPage Technology creates custom software, responsive web applications, mobile apps, and AI automations that scale businesses.\";',2109417027),('uppage-technology-cache-setting_meta_keywords_default','s:96:\"software development, web design, mobile apps, AI automation, custom software, digital solutions\";',2109417027),('uppage-technology-cache-setting_meta_title_default','s:70:\"UpPage Technology | Building Digital Solutions. Empowering Businesses.\";',2109417027),('uppage-technology-cache-setting_site_description','s:170:\"UpPage Technology is a premium software development and digital solutions company crafting custom web applications, mobile apps, and AI automation for global enterprises.\";',2109417027),('uppage-technology-cache-setting_site_logo','s:34:\"/assets/images/logo-horizontal.png\";',2109417027),('uppage-technology-cache-setting_site_logo_dark','s:39:\"/assets/images/logo-horizontal-dark.png\";',2109417027),('uppage-technology-cache-setting_site_logo_full','s:23:\"/assets/images/logo.png\";',2109417027),('uppage-technology-cache-setting_site_logo_icon','s:40:\"/assets/images/logo-icon-transparent.png\";',2109417027),('uppage-technology-cache-setting_social_facebook','s:31:\"https://facebook.com/uppagetech\";',2109417028),('uppage-technology-cache-setting_social_github','s:29:\"https://github.com/uppagetech\";',2109417028),('uppage-technology-cache-setting_social_linkedin','s:46:\"https://linkedin.com/company/uppage-technology\";',2109417028),('uppage-technology-cache-setting_social_twitter','s:24:\"https://x.com/uppagetech\";',2109417028),('uppage-technology-cache-setting_stat_clients_count','s:3:\"50+\";',2109417027),('uppage-technology-cache-setting_stat_projects_count','s:4:\"120+\";',2109417027),('uppage-technology-cache-setting_stat_satisfaction_count','s:3:\"98%\";',2109417027),('uppage-technology-cache-setting_stat_years_count','s:2:\"5+\";',2109417027);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_inquiries`
--

DROP TABLE IF EXISTS `contact_inquiries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_inquiries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_interested` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_inquiries`
--

LOCK TABLES `contact_inquiries` WRITE;
/*!40000 ALTER TABLE `contact_inquiries` DISABLE KEYS */;
INSERT INTO `contact_inquiries` VALUES (1,'Michael Chen','mchen@innovatecorp.com','+1 (415) 890-1234','Custom SaaS Platform Development','Hello UpPage team, we are seeking an engineering partner to develop an enterprise supply-chain management portal with real-time analytics. We would love to schedule an introductory call this week.','Custom Software Development','new',NULL,'127.0.0.1','2026-11-06 22:55:05','2026-11-06 22:55:05'),(2,'Sophia Taylor','sophia@retailpulse.io','+1 (212) 555-0199','Mobile App for iOS & Android','We are launching a new consumer shopping app and need cross-platform mobile development with Flutter or React Native. Looking for MVP delivery within 3 months.','Mobile App Development','read',NULL,'127.0.0.1','2026-11-06 22:55:05','2026-11-06 22:55:05'),(3,'David Morales','david@aiworkflows.co','+1 (312) 777-8899','AI Automation for Customer Support','We want to integrate automated AI agents to handle 50% of our tier-1 helpdesk inquiries. Can you provide a scope of work and timeline?','AI Automation','in_progress','Sent initial technical questionnaire. Awaiting client reply.','127.0.0.1','2026-11-06 22:55:05','2026-11-06 22:55:05');
/*!40000 ALTER TABLE `contact_inquiries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `departments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `manager_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `departments_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (1,'Software Engineering','ENG','Full-stack web, mobile, and backend development squads.','Alexander Hayes','2026-11-06 23:26:57','2026-11-06 23:26:57'),(2,'UI/UX Design','DSN','Product design, user research, wireframing and design systems.','Maya Lin','2026-11-06 23:26:57','2026-11-06 23:26:57'),(3,'Quality Assurance & Testing','QA','Automated regression, performance and security testing.','Rohit Nanda','2026-11-06 23:26:57','2026-11-06 23:26:57'),(4,'Cloud & DevOps Infrastructure','OPS','CI/CD pipelines, Kubernetes clusters, and AWS architecture.','Chloe Bennett','2026-11-06 23:26:57','2026-11-06 23:26:57'),(5,'HR & Operations','HRO','Talent acquisition, employee wellness, and corporate ops.','Sarah Vance','2026-11-06 23:26:57','2026-11-06 23:26:57');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `digital_solutions`
--

DROP TABLE IF EXISTS `digital_solutions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `digital_solutions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'layers',
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `features` json DEFAULT NULL,
  `benefits` json DEFAULT NULL,
  `technologies` json DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `digital_solutions_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `digital_solutions`
--

LOCK TABLES `digital_solutions` WRITE;
/*!40000 ALTER TABLE `digital_solutions` DISABLE KEYS */;
INSERT INTO `digital_solutions` VALUES (1,'Enterprise Software Solutions','enterprise-software-solutions','building','Enterprise','Robust, mission-critical software systems designed for high scalability, compliance, and multi-tenant architectures.','We engineer enterprise platforms that handle heavy transactional volume, multi-department workflows, and strict compliance mandates without skipping a beat.','[\"Multi-tenant Architecture\", \"Enterprise Single Sign-On (SSO)\", \"Role-Based Permissions\", \"Audit Logs & Governance\", \"High Availability Clusters\"]','[\"Scale horizontally with zero downtime\", \"Institutional compliance readiness\", \"Seamless integration with existing enterprise stacks\"]','[\"Laravel\", \"Docker\", \"Kubernetes\", \"Redis\", \"PostgreSQL\"]',1,1,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(2,'Business Automation','business-automation','workflow','Automation','Automate repetitive workflows, invoicing, data reconciliation, and customer communications.','Eliminate manual bottlenecks with custom event-driven automations connecting your internal tools and external services seamlessly.','[\"Event-driven triggers\", \"Document generation & signing\", \"ERP & CRM synchronization\", \"Scheduled batch processing\"]','[\"Save hundreds of team hours monthly\", \"Eliminate manual transcription errors\", \"Accelerate lead turnaround\"]','[\"PHP 8.4\", \"Laravel Queues\", \"Webhooks\", \"Zapier\", \"Python\"]',2,1,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(3,'AI-Powered Solutions','ai-powered-solutions','cpu','Artificial Intelligence','Next-generation AI agents, conversational interfaces, and intelligent data analysis pipelines.','Supercharge your operations with domain-trained LLM models, semantic search, and predictive analytics designed for business intelligence.','[\"Custom RAG Knowledge Bases\", \"Domain-specific Chatbots\", \"Automated Semantic Classification\", \"Predictive Modeling\"]','[\"Instant, accurate answers from company docs\", \"24/7 autonomous client interaction\", \"Actionable predictive insights\"]','[\"OpenAI\", \"Gemini API\", \"LangChain\", \"ChromaDB\", \"Python\"]',3,1,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(4,'Web Applications','web-applications','browser','Web','Blazing fast, responsive web platforms built with modern frontend and backend frameworks.','Custom portal software, dashboards, customer management portals, and booking engines built to scale smoothly across any screen resolution.','[\"Single Page Applications\", \"PWA Offline Capabilities\", \"Real-time WebSocket Notifications\", \"SEO Optimized\"]','[\"Delightful user journeys\", \"Superb performance on desktop and mobile\", \"Easy content management\"]','[\"Laravel\", \"Vue.js\", \"React\", \"Tailwind CSS\"]',4,1,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(5,'Mobile Applications','mobile-applications','smartphone','Mobile','Native and hybrid iOS & Android apps that deliver fluid UI and seamless device hardware integration.','From initial concept wireframes to App Store approval, we build mobile experiences that drive engagement and stickiness.','[\"iOS & Android cross-platform\", \"Push notification pipelines\", \"In-app purchases & subscriptions\", \"Camera & Bluetooth APIs\"]','[\"Unified codebase saving 40% maintenance costs\", \"Smooth 60 FPS user animations\", \"Instant app store compliance\"]','[\"Flutter\", \"React Native\", \"Firebase\", \"RESTful API\"]',5,1,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(6,'Cloud-Based Solutions','cloud-based-solutions','cloud','Cloud','Cloud infrastructure architecture, automated deployment pipelines, and serverless computing.','Migrate, optimize, and maintain your cloud footprint across AWS, Google Cloud, and DigitalOcean with modern CI/CD automation.','[\"Auto-scaling server clusters\", \"Serverless microservices\", \"Database replication & failover\", \"Continuous Deployment (CI/CD)\"]','[\"Pay only for compute resources you use\", \"99.99% uptime resilience\", \"Zero-downtime releases\"]','[\"AWS\", \"Google Cloud\", \"Docker\", \"Terraform\", \"GitHub Actions\"]',6,1,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(7,'Custom Business Platforms','custom-business-platforms','shield','Platforms','Bespoke operational platforms customized to your specific industry guidelines and workflow rules.','We create specialized portals, member dashboards, and internal operating systems that match your company workflows 100%.','[\"Custom Workflow Logic\", \"Role Hierarchy & Audit Logs\", \"Granular Reporting Dashboards\", \"Document Vaults\"]','[\"Eliminate per-user monthly SaaS fees\", \"Complete control over data & feature roadmap\", \"Accelerated team onboarding\"]','[\"Laravel\", \"MySQL\", \"Alpine.js\", \"Tailwind CSS\"]',7,1,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(8,'API & System Integration','api-system-integration','share-2','Integration','Connect disparate software, payment gateways, CRM engines, and legacy databases into unified data flows.','Break down silos between systems. We build bi-directional synchronizations with payment gateways, ERPs, accounting tools, and third-party APIs.','[\"Bi-directional data sync\", \"Webhook endpoints with retry handling\", \"Data mapping & transformation\", \"Secure API keys & throttling\"]','[\"Centralized source of operational truth\", \"Real-time billing and payment confirmation\", \"Robust error tracking and alert logs\"]','[\"REST API\", \"GraphQL\", \"Stripe\", \"Twilio\", \"Zapier\"]',8,1,'2026-11-06 22:55:05','2026-11-06 22:55:05');
/*!40000 ALTER TABLE `digital_solutions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department_id` bigint unsigned DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `joining_date` date NOT NULL,
  `salary` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` enum('active','on_leave','terminated') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employees_employee_id_unique` (`employee_id`),
  UNIQUE KEY `employees_email_unique` (`email`),
  KEY `employees_department_id_foreign` (`department_id`),
  CONSTRAINT `employees_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (1,'EMP-101','David Morales','david.morales@craftbycode.com','+1 (415) 301-4455',1,'Senior Full-Stack Engineer','2023-03-15',95000.00,'active','/assets/images/team/team-1.jpg','742 Evergreen Terrace, San Francisco, CA','+1 (415) 888-9900 (Spouse)','2026-11-06 23:26:57','2026-11-06 23:26:57'),(2,'EMP-102','Sophia Chen','sophia.chen@craftbycode.com','+1 (415) 301-8899',2,'Lead Product Designer','2023-06-01',88000.00,'active','/assets/images/team/team-2.jpg','120 Market St, Apt 4B, San Francisco, CA','+1 (415) 555-1212 (Father)','2026-11-06 23:26:57','2026-11-06 23:26:57'),(3,'EMP-103','Marcus Rivera','marcus.rivera@craftbycode.com','+1 (415) 301-7711',1,'Backend API Architect','2022-11-10',105000.00,'active','/assets/images/team/team-3.jpg','88 King St, San Francisco, CA','+1 (415) 444-3322 (Brother)','2026-11-06 23:26:57','2026-11-06 23:26:57'),(4,'EMP-104','Elena Rostova','elena.rostova@craftbycode.com','+1 (415) 301-2244',4,'DevOps Cloud Specialist','2024-01-20',92000.00,'active','/assets/images/team/team-4.jpg','456 Mission Bay Blvd, San Francisco, CA','+1 (415) 777-6655 (Mother)','2026-11-06 23:26:57','2026-11-06 23:26:57'),(5,'EMP-105','James Wilson','james.wilson@craftbycode.com','+1 (415) 301-9933',3,'QA Automation Lead','2024-04-12',82000.00,'on_leave','/assets/images/testimonials/avatar-1.jpg','321 Harrison St, San Francisco, CA','+1 (415) 222-1100 (Spouse)','2026-11-06 23:26:57','2026-11-06 23:26:57'),(6,'EMP-106','Aria Patel','aria.patel@craftbycode.com','+1 (415) 301-6677',5,'People & Culture Manager','2023-09-01',80000.00,'active','/assets/images/testimonials/avatar-2.jpg','500 Howard St, San Francisco, CA','+1 (415) 999-0011 (Sister)','2026-11-06 23:26:57','2026-11-06 23:26:57');
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leaves`
--

DROP TABLE IF EXISTS `leaves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `leaves` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` bigint unsigned NOT NULL,
  `leave_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `days` int NOT NULL DEFAULT '1',
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `admin_remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `leaves_employee_id_foreign` (`employee_id`),
  CONSTRAINT `leaves_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leaves`
--

LOCK TABLES `leaves` WRITE;
/*!40000 ALTER TABLE `leaves` DISABLE KEYS */;
INSERT INTO `leaves` VALUES (1,5,'Sick Leave','2026-11-07','2026-11-09',3,'Viral flu and doctor recommended 3 days of rest.','approved','Approved by Alexander Hayes. Medical note received.','2026-11-06 23:26:57','2026-11-06 23:26:57'),(2,1,'Annual Paid Time Off','2026-11-12','2026-11-16',5,'Family vacation to Lake Tahoe.','pending',NULL,'2026-11-06 23:26:57','2026-11-06 23:26:57');
/*!40000 ALTER TABLE `leaves` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_01_01_000001_create_uppage_tables',1),(5,'2025_01_02_000001_create_hrms_tables',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payrolls`
--

DROP TABLE IF EXISTS `payrolls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payrolls` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` bigint unsigned NOT NULL,
  `month` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `basic_salary` decimal(12,2) NOT NULL,
  `allowance` decimal(12,2) NOT NULL DEFAULT '0.00',
  `deductions` decimal(12,2) NOT NULL DEFAULT '0.00',
  `net_salary` decimal(12,2) NOT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Bank Transfer',
  `status` enum('pending','processed','paid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payrolls_employee_id_foreign` (`employee_id`),
  CONSTRAINT `payrolls_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payrolls`
--

LOCK TABLES `payrolls` WRITE;
/*!40000 ALTER TABLE `payrolls` DISABLE KEYS */;
INSERT INTO `payrolls` VALUES (1,1,'November 2026',7916.67,500.00,250.00,8166.67,'2026-11-29','Bank Wire Transfer','processed','2026-11-06 23:26:57','2026-11-06 23:26:57'),(2,2,'November 2026',7333.33,500.00,250.00,7583.33,'2026-11-29','Bank Wire Transfer','processed','2026-11-06 23:26:57','2026-11-06 23:26:57'),(3,3,'November 2026',8750.00,500.00,250.00,9000.00,'2026-11-29','Bank Wire Transfer','processed','2026-11-06 23:26:57','2026-11-06 23:26:57'),(4,4,'November 2026',7666.67,500.00,250.00,7916.67,'2026-11-29','Bank Wire Transfer','processed','2026-11-06 23:26:57','2026-11-06 23:26:57'),(5,5,'November 2026',6833.33,500.00,250.00,7083.33,'2026-11-29','Bank Wire Transfer','processed','2026-11-06 23:26:57','2026-11-06 23:26:57'),(6,6,'November 2026',6666.67,500.00,250.00,6916.67,'2026-11-29','Bank Wire Transfer','processed','2026-11-06 23:26:57','2026-11-06 23:26:57');
/*!40000 ALTER TABLE `payrolls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `challenge` text COLLATE utf8mb4_unicode_ci,
  `solution` text COLLATE utf8mb4_unicode_ci,
  `results` text COLLATE utf8mb4_unicode_ci,
  `technologies` json DEFAULT NULL,
  `project_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `projects_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,'Analytics Dashboard','analytics-dashboard','Web Application','DataFlow Tech Ltd','/assets/images/projects/project-analytics.jpg','Real-time analytics dashboard for data-driven decisions.','A comprehensive, multi-tenant analytics dashboard giving enterprise clients real-time visibility into transactions, server health, user retention, and revenue funnels with sub-second chart rendering.','The client had disparate PostgreSQL and ClickHouse databases processing 50M events daily, causing slow query load times and fragmented reporting.','We engineered a centralized aggregation pipeline with Redis caching, Laravel backend, and interactive Chart.js widgets that update via WebSockets.','Dashboard load time dropped from 8.4 seconds to 120 milliseconds; client user retention improved by 45%.','[\"Laravel\", \"Vue.js\", \"Redis\", \"PostgreSQL\", \"Tailwind CSS\", \"Chart.js\"]','https://analytics.example.com',1,1,1,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(2,'Fitness App','fitness-app','Mobile App','FitPulse Global','/assets/images/projects/project-fitness.jpg','Cross-platform fitness app with tracking & analytics.','A sleek, cross-platform mobile application featuring interactive workout routines, heart-rate device pairing, calorie counters, and community social leaderboards.','Existing legacy app had frequent Bluetooth disconnects and poor offline synchronization during workouts.','Re-architected the app with Flutter and an offline-first SQLite sync engine paired with a scalable Laravel API on AWS.','Achieved 4.9-star App Store rating with over 200,000 active monthly subscribers within six months of launch.','[\"Flutter\", \"Dart\", \"Laravel API\", \"Firebase\", \"Stripe\"]','https://fitpulse.example.com',2,1,1,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(3,'Modern E-commerce','modern-e-commerce','E-Commerce','Aura Living','/assets/images/projects/project-ecommerce.jpg','Full-stack e-commerce solution with seamless experience.','A high-converting direct-to-consumer lifestyle commerce platform featuring personalized recommendations, multi-currency pricing, and one-click checkout.','High checkout drop-off rates due to complicated checkout steps and slow image rendering during flash sales.','Built an ultrafast headless store architecture with sub-second edge CDN caching, simplified checkout flow, and automated abandoned cart recovery.','Conversion rate jumped from 1.8% to 4.2%; cart abandonment dropped by 34%.','[\"Laravel\", \"Tailwind CSS\", \"Alpine.js\", \"Stripe\", \"MySQL\", \"Cloudflare\"]','https://auraliving.example.com',3,1,1,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(4,'Project Management Tool','project-management-tool','SaaS Platform','SyncTask Inc','/assets/images/projects/project-saas.jpg','SaaS platform to manage projects, tasks and team efficiency.','An intuitive project management suite enabling agile squads to plan sprints, track time, automate approvals, and collaborate across global timezones.','Scaling WebSocket communication and Kanban drag-and-drop state across thousands of simultaneous remote team members.','Implemented optimistic UI state handling, Redis Pub/Sub WebSocket event channels, and modular board architecture.','Adopted by 350+ technology agencies with 99.98% uptime SLA compliance.','[\"Laravel\", \"Vue.js\", \"WebSockets\", \"Tailwind CSS\", \"Docker\"]','https://synctask.example.com',4,1,1,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(5,'AI Automated Customer Support','ai-automated-customer-support','AI Automation','Nexus Cloud Care','/assets/images/projects/project-ai.jpg','Autonomous customer support agent resolving 65% tickets instantly.','Enterprise conversational AI agent integrated with Zendesk and internal knowledge bases to autonomously answer complex technical customer queries.','Support team overwhelmed by 5,000+ repetitive tier-1 tickets per week with slow first-response times.','Developed custom RAG AI pipeline with vector embedding search, sentiment analysis, and intelligent human agent handoff.','First response time reduced from 4 hours to 12 seconds; ticket resolution satisfaction reached 94%.','[\"Python\", \"OpenAI\", \"Laravel\", \"LangChain\", \"Pinecone\"]','https://nexuscare.example.com',5,0,1,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(6,'Enterprise Health Cloud','enterprise-health-cloud','Web Application','MediCore Health','/assets/images/projects/project-health.jpg','HIPAA-compliant patient portal and telemedicine engine.','Secure telemedicine platform facilitating end-to-end video consultations, encrypted electronic medical records, and digital prescriptions.','Strict healthcare privacy compliance and low-latency video streaming in rural connectivity areas.','Engineered end-to-end encrypted WebRTC streaming, audit-trailed database records, and automated SMS appointment reminders.','Safely processed over 150,000 patient tele-visits with 100% HIPAA audit compliance.','[\"Laravel\", \"WebRTC\", \"MySQL\", \"Tailwind CSS\", \"AWS S3 Vault\"]','https://medicore.example.com',6,0,1,'2026-11-06 22:55:05','2026-11-06 22:55:05');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'code',
  `badge` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `features` json DEFAULT NULL,
  `benefits` json DEFAULT NULL,
  `tech_stack` json DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `services_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,'Web Development','web-development','globe','Most Popular','Fast, responsive and scalable web applications built for growth and seamless user experience.','We engineer high-performance web applications that combine stunning visual aesthetics with scalable architecture. From modern single-page applications to enterprise web platforms, our team leverages cutting-edge frameworks like Laravel, Vue, React, and Tailwind CSS to create responsive, secure, and SEO-optimized solutions.','[\"Custom Full-Stack Development\", \"Single Page Applications (SPA)\", \"Progressive Web Apps (PWA)\", \"Responsive UI Across All Devices\", \"Performance & Speed Optimization\", \"Enterprise CMS Solutions\"]','[\"Lightning-fast load times boosting conversion rates\", \"Clean, maintainable, and extensible code architecture\", \"SEO-ready structure to maximize search visibility\", \"Enterprise-grade security and data encryption\"]','[\"Laravel\", \"PHP 8.4\", \"Vue.js\", \"React\", \"Tailwind CSS\", \"MySQL\", \"Redis\"]',1,1,1,NULL,NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(2,'Mobile App Development','mobile-app-development','smartphone','Trending','Cross-platform mobile apps for Android & iOS that users love and engage with daily.','Transform your mobile presence with robust, native-feel iOS and Android applications. We deliver end-to-end mobile engineering from intuitive UX wireframing to App Store and Google Play deployment, utilizing modern cross-platform technologies to cut time-to-market while delivering 60fps performance.','[\"iOS & Android Cross-Platform Apps\", \"Native Performance & Hardware Integration\", \"Offline Mode & Local Data Sync\", \"Push Notifications & User Re-engagement\", \"Biometric Authentication & In-App Purchases\", \"App Store & Play Store Publishing\"]','[\"Single codebase reducing development costs by 40%\", \"Smooth, native animations and ultra-responsive touch\", \"Continuous real-time cloud analytics and crash reporting\", \"Effortless scalability supporting millions of daily active users\"]','[\"Flutter\", \"React Native\", \"Swift\", \"Kotlin\", \"Firebase\", \"RESTful API\"]',2,1,1,NULL,NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(3,'UI/UX Design','ui-ux-design','palette','Creative','Beautiful, user-centric designs that convert visitors into loyal, paying customers.','User experience is at the core of every digital product we construct. Our human-centered design approach marries user psychology, rigorous research, interactive prototyping, and pixel-perfect interface design to turn complex workflows into delightful user journeys.','[\"User Journey Mapping & Persona Research\", \"Interactive Wireframing & Clickable Prototypes\", \"Comprehensive Design Systems & Tokens\", \"Micro-interactions & Motion Design\", \"Accessibility (WCAG 2.1) Compliance\", \"Usability Testing & Feedback Loops\"]','[\"Dramatically increased user engagement and retention\", \"Clear, conversion-focused user navigation journeys\", \"Standardized design system speeding up frontend engineering\", \"Modern, memorable brand impression that outshines competitors\"]','[\"Figma\", \"Adobe XD\", \"Protopie\", \"Tailwind CSS\", \"Storybook\"]',3,1,1,NULL,NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(4,'AI Automation','ai-automation','cpu','AI Powered','AI automation and smart tools for modern businesses looking to scale operations intelligently.','Harness the transformative power of generative AI, large language models, and automated machine workflows. We build intelligent agentic systems, predictive analytics, natural language assistants, and workflow automations that eliminate redundant manual operations.','[\"LLM Integration (OpenAI, Claude, Gemini)\", \"Custom AI Knowledge Bases & RAG Systems\", \"Autonomous Workflow & Task Automations\", \"Intelligent Document & Data Extraction\", \"Predictive Business Intelligence & Analytics\", \"Smart AI Customer Support Agents\"]','[\"Eliminate up to 70% of repetitive operational workloads\", \"24/7 intelligent automated customer assistance\", \"Actionable business foresight derived from unstructured data\", \"Safe, private AI setups complying with data governance\"]','[\"Python\", \"OpenAI API\", \"LangChain\", \"FastAPI\", \"Vector DB\", \"PyTorch\"]',4,1,1,NULL,NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(5,'Custom Software Development','custom-software-development','code','Core','Tailored software solutions built from the ground up to solve your unique operational challenges.','Off-the-shelf software rarely addresses the nuanced operational requirements of growing enterprises. We engineer custom bespoke software tailored precisely to your internal processes, compliance constraints, and long-term vision.','[\"Tailored Architecture & Domain Modeling\", \"Microservices & Modular Monoliths\", \"Role-Based Access Control (RBAC)\", \"Auditing, Logging & Security Hardening\", \"Database Optimization & Scalability Planning\", \"Legacy System Modernization & Refactoring\"]','[\"100% intellectual property ownership with zero vendor lock-in\", \"Seamless fit with your proprietary business procedures\", \"Built to scale seamlessly without recurring per-seat fees\", \"Comprehensive documentation and developer handoff\"]','[\"Laravel\", \"PostgreSQL\", \"Docker\", \"Kubernetes\", \"GraphQL\", \"AWS\"]',5,1,1,NULL,NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(6,'API Integration','api-integration','git-merge','Connectivity','Seamless third-party API integration and robust custom RESTful and GraphQL API development.','Connect fragmented software ecosystems into cohesive operational powerhouses. We architect secure, documented, and resilient APIs while connecting your platforms to external payment gateways, CRM systems, shipping providers, and marketing engines.','[\"RESTful & GraphQL API Architecture\", \"Secure OAuth2 & JWT Authentication\", \"Stripe, PayPal & Razorpay Payment Integrations\", \"ERP, CRM & Webhook Automation\", \"Rate Limiting & DDOS Throttling\", \"Comprehensive OpenAPI / Swagger Documentation\"]','[\"Eliminate data silos between software tools\", \"Instant real-time data sync across platforms\", \"High-throughput fault tolerance with queue retries\", \"Developer-friendly developer portal and mock sandbox\"]','[\"REST\", \"GraphQL\", \"Webhooks\", \"OAuth2\", \"Stripe\", \"Twilio\", \"Zapier\"]',6,0,1,NULL,NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(7,'Business Management Software','business-management-software','briefcase','Enterprise','Integrated ERP, CRM, and inventory management systems designed for operational excellence.','Equip your leadership and departments with unified business intelligence and operational command. We design custom ERP, HRM, invoicing, inventory tracking, and client management systems tailored to streamline team collaboration.','[\"Custom CRM & Sales Pipeline Management\", \"Multi-Warehouse Inventory & Supply Chain Tracking\", \"Automated Invoicing & Financial Accounting\", \"HRM, Payroll & Employee Attendance Portals\", \"Executive Analytics & Real-Time Reporting\", \"Multi-Branch & Multi-Currency Capability\"]','[\"Consolidate 5+ fragmented apps into one unified dashboard\", \"Drastically reduce human data entry errors\", \"Real-time transparency on revenue, costs, and inventory\", \"Automate recurring approvals and task assignments\"]','[\"Laravel\", \"MySQL\", \"Livewire\", \"Tailwind CSS\", \"Chart.js\", \"Export Tools\"]',7,0,1,NULL,NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(8,'E-commerce Development','e-commerce-development','shopping-cart','High ROI','Full-stack e-commerce solutions with frictionless checkout, inventory sync, and maximum conversions.','Build high-converting digital storefronts crafted for speed, trust, and frictionless mobile purchasing. From bespoke multi-vendor marketplaces to custom WooCommerce and Shopify Plus extensions, we ensure each click drives revenue.','[\"Frictionless One-Click Checkout Architecture\", \"Multi-Currency & Multilingual Localization\", \"Inventory Sync & Order Fulfillment Automation\", \"Discount Engines & Customer Loyalty Programs\", \"Abandoned Cart Recovery Automation\", \"Payment Gateway Integration (Stripe, Apple Pay, Google Pay)\"]','[\"Significant reduction in shopping cart drop-offs\", \"Sub-second product catalog search & faceted filters\", \"Omnichannel inventory synchronization\", \"PCI-DSS compliant payment processing security\"]','[\"Laravel\", \"Shopify Plus\", \"WooCommerce\", \"Stripe\", \"Tailwind CSS\", \"Algolia\"]',8,0,1,NULL,NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(9,'Website Maintenance & Support','website-maintenance-support','shield-check','24/7 Support','Proactive monitoring, security patching, cloud backups, and performance fine-tuning.','Keep your digital flagship operating at peak performance around the clock. Our dedicated maintenance engineers provide proactive uptime monitoring, automated cloud backups, SSL certification, vulnerability patching, and SLA-backed emergency responses.','[\"24/7 Automated Uptime & Error Alerting\", \"Daily Encrypted Off-Site Backups\", \"Core Framework & Security Patch Updates\", \"Database Performance Tuning & Indexing\", \"Malware Scanning & Web Application Firewall\", \"Dedicated SLA Support & Feature Enhancements\"]','[\"99.9% guaranteed uptime assurance\", \"Zero business interruption from unexpected crashes\", \"Guaranteed rapid response from senior engineers\", \"Continuous optimization keeping your site ahead of curves\"]','[\"AWS CloudWatch\", \"Sentry\", \"Cloudflare\", \"GitHub Actions\", \"Docker\"]',9,0,1,NULL,NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('IxJI0wjU8SHhh3kyhMmRNFi3GzjyaETCP3X6CbBa',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJscFB2WGRPa3luZnBQbnpPdHE2aU9mUXlobXdaQTRUc2FEY1ZxWjBmIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvbG9naW4iLCJyb3V0ZSI6ImFkbWluLmxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1794057051);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testimonials`
--

DROP TABLE IF EXISTS `testimonials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `testimonials` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `client_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` int NOT NULL DEFAULT '5',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonials`
--

LOCK TABLES `testimonials` WRITE;
/*!40000 ALTER TABLE `testimonials` DISABLE KEYS */;
INSERT INTO `testimonials` VALUES (1,'Rohit Sharma','CEO','D2C Startup','/assets/images/testimonials/avatar-1.jpg',5,'UpPage Technology transformed our idea into a powerful digital product. Their team is professional, creative and super responsive. They delivered well ahead of schedule and the code quality is top-notch.',1,1,1,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(2,'Anjali Verma','Product Manager','FinScale Systems','/assets/images/testimonials/avatar-2.jpg',5,'Amazing experience from start to finish. They delivered on time and the quality exceeded our expectations. The attention to detail in UX design and backend stability made all the difference.',2,1,1,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(3,'Vikram Patel','Founder','SaaS Company','/assets/images/testimonials/avatar-3.jpg',5,'Their attention to detail and technical expertise is outstanding. Highly recommended! We have partnered with them on 4 consecutive product launches and each has been a major commercial success.',3,1,1,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(4,'Sarah Jenkins','VP of Engineering','CloudScale Global','/assets/images/testimonials/avatar-4.jpg',5,'UpPage Technology is the most dependable engineering partner we have ever contracted with. Clean Laravel architecture, prompt communication, and zero technical debt. Truly world-class.',4,0,1,'2026-11-06 22:55:05','2026-11-06 22:55:05');
/*!40000 ALTER TABLE `testimonials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin UpPage','admin@uppage.tech',NULL,'$2y$12$Q6Ff9acusGGwNS52wtgZ.OUbAoVjbTC2Spzkx6bQQR2Qk2znpnIb6','admin','+1 (555) 019-2834',NULL,NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(2,'Lead Engineer','admin@craftbycode.com',NULL,'$2y$12$4z0phoIWKszUFBsKVz0ikusxUoSCKtfx3tyT4FGjCBHheQ1UfuzUK','admin','+1 (555) 019-2835',NULL,NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `website_settings`
--

DROP TABLE IF EXISTS `website_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `website_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `website_settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `website_settings`
--

LOCK TABLES `website_settings` WRITE;
/*!40000 ALTER TABLE `website_settings` DISABLE KEYS */;
INSERT INTO `website_settings` VALUES (1,'general','brand_name','craft by code','text','Company Brand Name',NULL,'2026-11-06 22:55:05','2026-11-07 07:37:22'),(2,'general','brand_tagline','CODE • DESIGN • SOLVE • INNOVATE','text','Primary Brand Tagline',NULL,'2026-11-06 22:55:05','2026-11-07 07:37:22'),(3,'general','site_description','UpPage Technology is a premium software development and digital solutions company crafting custom web applications, mobile apps, and AI automation for global enterprises.','textarea','Site Description',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(4,'general','brand_badge','TRUSTED BY STARTUPS & BUSINESSES WORLDWIDE','text','Hero Badge Text',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(5,'hero','hero_headline_1','WE DESIGN.','text','Hero Line 1',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(6,'hero','hero_headline_2','WE CODE.','text','Hero Line 2',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(7,'hero','hero_headline_gradient','WE INNOVATE.','text','Hero Highlight / Gradient Line',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(8,'hero','hero_subtitle','We build custom digital products, AI automation tools, and MVPs that help startups and businesses grow faster.','textarea','Hero Subtitle',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(9,'hero','hero_cta_primary_text','Explore Services','text','Hero Primary Button Text',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(10,'hero','hero_cta_primary_url','/services','text','Hero Primary Button Link',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(11,'hero','hero_cta_secondary_text','Let\'s Talk','text','Hero Secondary Button Text',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(12,'hero','hero_cta_secondary_url','/contact','text','Hero Secondary Button Link',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(13,'stats','stat_clients_count','50+','text','Happy Clients Count',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(14,'stats','stat_clients_label','Happy Clients','text','Happy Clients Label',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(15,'stats','stat_projects_count','120+','text','Projects Completed Count',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(16,'stats','stat_projects_label','Projects Completed','text','Projects Completed Label',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(17,'stats','stat_years_count','5+','text','Years Experience Count',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(18,'stats','stat_years_label','Years Experience','text','Years Experience Label',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(19,'stats','stat_satisfaction_count','98%','text','Client Satisfaction Rate',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(20,'stats','stat_satisfaction_label','Client Satisfaction','text','Client Satisfaction Label',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(21,'contact','contact_email','hello@uppage.tech','text','Company Email',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(22,'contact','contact_phone','+1 (555) 019-2834','text','Company Phone',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(23,'contact','contact_address','100 Innovation Way, Suite 400, San Francisco, CA 94105','text','Company Address',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(24,'contact','contact_hours','Monday - Friday: 9:00 AM - 6:00 PM EST','text','Working Hours',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(25,'contact','google_maps_url','https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.0863816568285!2d-122.39997232348573!3d37.78802271168436!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80858062828b8c73%3A0x6b63d91cf3241bc3!2sMarket%20St%2C%20San%20Francisco%2C%20CA!5e0!3m2!1sen!2sus!4v1710000000000!5m2!1sen!2sus','textarea','Google Maps Embed URL',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(26,'social','social_linkedin','https://linkedin.com/company/uppage-technology','text','LinkedIn URL',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(27,'social','social_twitter','https://x.com/uppagetech','text','Twitter/X URL',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(28,'social','social_github','https://github.com/uppagetech','text','GitHub URL',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(29,'social','social_facebook','https://facebook.com/uppagetech','text','Facebook URL',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(30,'cta','cta_title','Let\'s build something amazing together','text','Call To Action Title',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(31,'cta','cta_subtitle','Have a project in mind? Let\'s turn your idea into reality.','text','Call To Action Subtitle',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(32,'cta','cta_button_text','Start a Project','text','Call To Action Button Text',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(33,'cta','cta_button_url','/contact','text','Call To Action Button URL',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(34,'seo','meta_title_default','UpPage Technology | Building Digital Solutions. Empowering Businesses.','text','Default Meta Title',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(35,'seo','meta_description_default','UpPage Technology creates custom software, responsive web applications, mobile apps, and AI automations that scale businesses.','textarea','Default Meta Description',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(36,'seo','meta_keywords_default','software development, web design, mobile apps, AI automation, custom software, digital solutions','text','Default Meta Keywords',NULL,'2026-11-06 22:55:05','2026-11-06 22:55:05'),(37,'general','site_logo','/assets/images/logo-horizontal.png','image','Primary Website Logo',NULL,'2026-11-06 23:53:22','2026-11-06 23:53:22'),(38,'general','site_logo_dark','/assets/images/logo-horizontal-dark.png','image','Dark Mode Logo',NULL,'2026-11-06 23:53:22','2026-11-06 23:53:22'),(39,'general','site_logo_icon','/assets/images/logo-icon-transparent.png','image','Logo Icon / Favicon',NULL,'2026-11-06 23:53:22','2026-11-06 23:53:22'),(40,'general','site_logo_full','/assets/images/logo.png','image','Full Graphic Logo Badge',NULL,'2026-11-06 23:53:22','2026-11-06 23:53:22'),(41,'general','brand_sub_tagline','UI/UX • DEVELOPMENT • CREATIVE SOLUTIONS','text','Sub-Tagline / Specializations',NULL,'2026-11-06 23:53:22','2026-11-07 07:37:22'),(42,'general','logo_display_mode','horizontal_logo','select','Logo Display Mode',NULL,'2026-11-06 23:53:22','2026-11-06 23:53:22');
/*!40000 ALTER TABLE `website_settings` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-09 23:37:54
