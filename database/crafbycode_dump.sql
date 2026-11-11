-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for osx10.10 (x86_64)
--
-- Host: 127.0.0.1    Database: crafbycode
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `about_contents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `section_key` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
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
INSERT INTO `about_contents` VALUES (1,'intro','Transforming Ideas Into World-Class Digital Solutions','About UpPage Technology','Founded with a passion for software craftsmanship, UpPage Technology empowers startups and enterprises with high-velocity digital solutions. We bridge the gap between creative visual design and complex technical architecture to engineer digital products that solve real-world problems and generate measurable ROI.',NULL,1,1,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(2,'story','Our Story: Born to Build Better','How We Started','UpPage Technology started as a tight-knit collective of seasoned engineers and product designers frustrated with bureaucratic agencies that overpromised and underdelivered. We resolved to construct an engineering firm centered on transparent communication, clean code craftsmanship, and relentless commitment to client success. Over the past 5+ years, we have grown into a trusted technology partner for startups, unicorns, and established businesses across North America, Europe, and Asia.',NULL,2,1,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(3,'mission_vision','Mission & Vision','Our Guiding Star','Our mission is to empower businesses with transformative software engineering and thoughtful design. Our vision is to be the premier global technology studio recognized for setting new standards in software reliability, elegant UX, and high-impact digital innovation.','{\"mission\":\"Empowering modern enterprises through bespoke digital solutions that drive operational agility, revenue growth, and unforgettable customer experiences.\",\"vision\":\"To be the world\\u2019s most trusted software partner for innovators who refuse to compromise on quality, security, or design.\"}',3,1,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(4,'values','Core Values That Drive Every Line of Code','What We Stand For','Our engineering culture is governed by four core pillars that guide every decision we make.','[{\"title\":\"Craftsmanship First\",\"description\":\"We don\\u2019t cut corners. Every database query, API endpoint, and UI component is architected for clean readability and long-term durability.\"},{\"title\":\"Radical Transparency\",\"description\":\"Direct engineer-to-client communication with zero jargon. You always have full access to our git repositories and sprint progress.\"},{\"title\":\"User-Centric Innovation\",\"description\":\"Technology serves humans. We build software that is intuitive, empathetic, and effortless to adopt.\"},{\"title\":\"Speed Without Compromise\",\"description\":\"We launch high-velocity MVPs and features fast by leveraging modern tooling without sacrificing security or scalability.\"}]',4,1,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(5,'process','Our 5-Step Development Process','How We Work','A battle-tested agile methodology delivering predictable outcomes from day one.','[{\"step\":\"01\",\"title\":\"Discovery & Blueprinting\",\"description\":\"We deep-dive into your business goals, target audience, technical constraints, and deliver an actionable architecture roadmap.\"},{\"step\":\"02\",\"title\":\"UI\\/UX Prototyping\",\"description\":\"Our designers create interactive Figma prototypes, conducting user flow validations before a single line of backend code is written.\"},{\"step\":\"03\",\"title\":\"Agile Sprint Development\",\"description\":\"We build in iterative two-week sprints with automated CI\\/CD pipelines, allowing you to preview live staging builds continuously.\"},{\"step\":\"04\",\"title\":\"Rigorous QA & Security Audit\",\"description\":\"Comprehensive automated unit testing, end-to-end browser tests, load testing, and security vulnerability patching.\"},{\"step\":\"05\",\"title\":\"Deployment & 24\\/7 SLA Support\",\"description\":\"Zero-downtime production launch with proactive performance monitoring, cloud backups, and ongoing feature enhancement.\"}]',5,1,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(6,'why_trust','Why Fast-Growing Businesses Trust UpPage','The UpPage Advantage','We are not just contractors; we become an extension of your leadership team.','[{\"highlight\":\"100% IP Ownership\",\"desc\":\"You own all code, repositories, design assets, and intellectual property from day one.\"},{\"highlight\":\"Zero Technical Debt\",\"desc\":\"We write strictly tested, standard-compliant PHP 8.4, Laravel, and modern JavaScript.\"},{\"highlight\":\"Dedicated Project Managers\",\"desc\":\"Your single point of contact keeps sprints synchronized with daily asynchronous updates.\"},{\"highlight\":\"Scalable Infrastructure\",\"desc\":\"Cloud architecture ready to handle sudden traffic surges without downtime or cost spikes.\"}]',6,1,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(7,'team','Meet Our Core Leadership','The People Behind the Code','Senior technologists, creative strategists, and solution architects passionate about your success.','[{\"name\":\"Alexander Hayes\",\"role\":\"Founder & Chief Technology Officer\",\"bio\":\"12+ years building enterprise SaaS platforms and distributed cloud systems.\",\"image\":\"\\/assets\\/images\\/team\\/team-1.jpg\"},{\"name\":\"Maya Lin\",\"role\":\"Head of Product & UX Design\",\"bio\":\"Former design lead at Silicon Valley scale-ups with a focus on conversion UI.\",\"image\":\"\\/assets\\/images\\/team\\/team-2.jpg\"},{\"name\":\"Marcus Vance\",\"role\":\"Lead Full-Stack Architect\",\"bio\":\"Specializes in high-throughput Laravel APIs, database clustering, and security.\",\"image\":\"\\/assets\\/images\\/team\\/team-3.jpg\"},{\"name\":\"Chloe Bennett\",\"role\":\"AI & Cloud Infrastructure Lead\",\"bio\":\"Expert in LLM integration, automated agent workflows, and Kubernetes clusters.\",\"image\":\"\\/assets\\/images\\/team\\/team-4.jpg\"}]',7,1,'2026-10-31 08:28:28','2026-10-31 08:28:28');
/*!40000 ALTER TABLE `about_contents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_posts`
--

DROP TABLE IF EXISTS `blog_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `excerpt` text NOT NULL,
  `content` longtext NOT NULL,
  `read_time` varchar(255) NOT NULL DEFAULT '5 min read',
  `author_name` varchar(255) NOT NULL DEFAULT 'UpPage Team',
  `published_at` timestamp NULL DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
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
INSERT INTO `blog_posts` VALUES (1,'10 Best Practices for Clean Code in 2025','10-best-practices-for-clean-code','Development','/assets/images/blog/blog-code.jpg','Writing clean code is important for scalability, team speed, and long-term business success. Here are the 10 proven principles we practice every day.','<p>Writing clean, maintainable code is not just an aesthetic preference—it is a critical business strategy. In fast-moving technology companies, software that is difficult to understand or modify rapidly becomes technical debt that slows feature velocity to a crawl.</p><h3>1. Meaningful Names</h3><p>Choose names that reveal intent. A variable, function, or class name should tell you why it exists, what it does, and how it is used without requiring additional comments.</p><h3>2. Functions Should Do One Thing</h3><p>Functions should be small and do one thing only, and do it well. When a function executes multiple operations, extracting them into separate helper methods dramatically improves testability.</p><h3>3. Keep Controllers Thin</h3><p>In modern MVC architectures like Laravel, push business logic into Services, Actions, or Domain models. This preserves controller clarity and keeps endpoints reusable across API and web requests.</p>','5 min read','Alex Turner, Lead Architect','2026-10-26 08:28:28',1,1,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(2,'UI/UX Trends to Watch: Designing for Conversions','ui-ux-trends-to-watch','Design','/assets/images/blog/blog-design.jpg','Explore the latest UI/UX trends that are shaping the future of digital products, from spatial depth to hyper-personalized onboarding.','<p>User experience is experiencing a renaissance. As users interact with dozens of web and mobile apps daily, tolerance for confusing navigation or sluggish loading has dropped to zero.</p><h3>Micro-Interactions that Delight</h3><p>Subtle hover animations, button feedback ripples, and fluid tab transitions provide immediate psychological feedback, assuring users their inputs are registered.</p><h3>Minimalist Contrast & Accessibility</h3><p>Clean whitespace paired with bold typography and high-contrast electric accents ensures your message cuts through noise while complying with modern WCAG accessibility criteria.</p>','4 min read','Elena Rostova, Head of Design','2026-10-19 08:28:28',1,1,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(3,'How AI is Transforming Modern Businesses & Workflows','how-ai-is-transforming-businesses','AI','/assets/images/blog/blog-ai.jpg','AI automation tools are helping businesses save time, decrease overhead, and increase productivity tenfold. Discover how your team can leverage them.','<p>Artificial intelligence has transitioned from academic labs into daily business operations. Companies deploying automated workflows and generative assistants are discovering unprecedented productivity gains.</p><h3>Retrieval-Augmented Generation (RAG)</h3><p>By connecting Large Language Models directly to proprietary internal company wikis and support databases, organizations eliminate repetitive tier-1 support queries without risking data leaks.</p><h3>Automating Tedious Data Pipelines</h3><p>From automated PDF invoice parsing to real-time sentiment analysis on incoming client leads, AI removes friction from high-volume operations.</p>','6 min read','David Kim, AI Lead','2026-10-11 08:28:28',1,1,'2026-10-31 08:28:28','2026-10-31 08:28:28');
/*!40000 ALTER TABLE `blog_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('uppage-technology-cache-setting_brand_badge','s:42:\"TRUSTED BY STARTUPS & BUSINESSES WORLDWIDE\";',2109790455),('uppage-technology-cache-setting_brand_name','s:17:\"UpPage Technology\";',2109790454),('uppage-technology-cache-setting_brand_sub_tagline','s:44:\"UI/UX • DEVELOPMENT • CREATIVE SOLUTIONS\";',2109790454),('uppage-technology-cache-setting_brand_tagline','s:50:\"Building Digital Solutions. Empowering Businesses.\";',2109790454),('uppage-technology-cache-setting_contact_address','s:54:\"100 Innovation Way, Suite 400, San Francisco, CA 94105\";',2109790454),('uppage-technology-cache-setting_contact_email','s:17:\"hello@uppage.tech\";',2109790454),('uppage-technology-cache-setting_contact_hours','s:38:\"Monday - Friday: 9:00 AM - 6:00 PM EST\";',2109790476),('uppage-technology-cache-setting_contact_phone','s:17:\"+1 (555) 019-2834\";',2109790454),('uppage-technology-cache-setting_cta_button_text','s:15:\"Start a Project\";',2109790454),('uppage-technology-cache-setting_cta_button_url','s:8:\"/contact\";',2109790454),('uppage-technology-cache-setting_cta_subtitle','s:58:\"Have a project in mind? Let\'s turn your idea into reality.\";',2109790454),('uppage-technology-cache-setting_cta_title','s:38:\"Let\'s build something amazing together\";',2109790454),('uppage-technology-cache-setting_google_maps_url','s:295:\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.0863816568285!2d-122.39997232348573!3d37.78802271168436!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80858062828b8c73%3A0x6b63d91cf3241bc3!2sMarket%20St%2C%20San%20Francisco%2C%20CA!5e0!3m2!1sen!2sus!4v1710000000000!5m2!1sen!2sus\";',2109790476),('uppage-technology-cache-setting_hero_headline_1','s:10:\"WE DESIGN.\";',2109790455),('uppage-technology-cache-setting_hero_headline_2','s:8:\"WE CODE.\";',2109790455),('uppage-technology-cache-setting_hero_headline_gradient','s:12:\"WE INNOVATE.\";',2109790455),('uppage-technology-cache-setting_hero_subtitle','s:110:\"We build custom digital products, AI automation tools, and MVPs that help startups and businesses grow faster.\";',2109790455),('uppage-technology-cache-setting_logo_display_mode','s:15:\"horizontal_logo\";',2109790454),('uppage-technology-cache-setting_meta_description_default','s:126:\"UpPage Technology creates custom software, responsive web applications, mobile apps, and AI automations that scale businesses.\";',2109790454),('uppage-technology-cache-setting_meta_keywords_default','s:96:\"software development, web design, mobile apps, AI automation, custom software, digital solutions\";',2109790454),('uppage-technology-cache-setting_meta_title_default','s:70:\"UpPage Technology | Building Digital Solutions. Empowering Businesses.\";',2109790454),('uppage-technology-cache-setting_site_description','s:170:\"UpPage Technology is a premium software development and digital solutions company crafting custom web applications, mobile apps, and AI automation for global enterprises.\";',2109790454),('uppage-technology-cache-setting_site_logo','s:34:\"/assets/images/logo-horizontal.png\";',2109790454),('uppage-technology-cache-setting_site_logo_dark','s:39:\"/assets/images/logo-horizontal-dark.png\";',2109790454),('uppage-technology-cache-setting_site_logo_full','s:23:\"/assets/images/logo.png\";',2109790454),('uppage-technology-cache-setting_site_logo_icon','s:39:\"assets/images/logo-icon-transparent.png\";',2109790454),('uppage-technology-cache-setting_social_facebook','s:31:\"https://facebook.com/uppagetech\";',2109790454),('uppage-technology-cache-setting_social_github','s:29:\"https://github.com/uppagetech\";',2109790454),('uppage-technology-cache-setting_social_linkedin','s:46:\"https://linkedin.com/company/uppage-technology\";',2109790454),('uppage-technology-cache-setting_social_twitter','s:24:\"https://x.com/uppagetech\";',2109790454),('uppage-technology-cache-setting_stat_clients_count','s:3:\"50+\";',2109790455),('uppage-technology-cache-setting_stat_projects_count','s:4:\"120+\";',2109790455),('uppage-technology-cache-setting_stat_satisfaction_count','s:3:\"98%\";',2109790455),('uppage-technology-cache-setting_stat_years_count','s:2:\"5+\";',2109790455);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_inquiries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `service_interested` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `admin_notes` text DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_inquiries`
--

LOCK TABLES `contact_inquiries` WRITE;
/*!40000 ALTER TABLE `contact_inquiries` DISABLE KEYS */;
INSERT INTO `contact_inquiries` VALUES (1,'Michael Chen','mchen@innovatecorp.com','+1 (415) 890-1234','Custom SaaS Platform Development','Hello UpPage team, we are seeking an engineering partner to develop an enterprise supply-chain management portal with real-time analytics. We would love to schedule an introductory call this week.','Custom Software Development','new',NULL,'127.0.0.1','2026-10-31 08:28:28','2026-10-31 08:28:28'),(2,'Sophia Taylor','sophia@retailpulse.io','+1 (212) 555-0199','Mobile App for iOS & Android','We are launching a new consumer shopping app and need cross-platform mobile development with Flutter or React Native. Looking for MVP delivery within 3 months.','Mobile App Development','read',NULL,'127.0.0.1','2026-10-31 08:28:28','2026-10-31 08:28:28'),(3,'David Morales','david@aiworkflows.co','+1 (312) 777-8899','AI Automation for Customer Support','We want to integrate automated AI agents to handle 50% of our tier-1 helpdesk inquiries. Can you provide a scope of work and timeline?','AI Automation','in_progress','Sent initial technical questionnaire. Awaiting client reply.','127.0.0.1','2026-10-31 08:28:28','2026-10-31 08:28:28'),(4,'Automated Test Prospect','testprospect@acme.com','+1 (555) 999-8877','Enterprise Cloud Migration Test','This is an end-to-end automated verification message to test the inquiry storage.','Custom Software Development','new',NULL,'127.0.0.1','2026-10-31 10:12:42','2026-10-31 10:12:42');
/*!40000 ALTER TABLE `contact_inquiries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
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
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_01_01_000001_create_uppage_tables',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
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
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `summary` text NOT NULL,
  `description` longtext DEFAULT NULL,
  `challenge` text DEFAULT NULL,
  `solution` text DEFAULT NULL,
  `results` text DEFAULT NULL,
  `technologies` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`technologies`)),
  `project_url` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
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
INSERT INTO `projects` VALUES (1,'Analytics Dashboard','analytics-dashboard','Web Application','DataFlow Tech Ltd','/assets/images/projects/project-analytics.jpg','Real-time analytics dashboard for data-driven decisions.','A comprehensive, multi-tenant analytics dashboard giving enterprise clients real-time visibility into transactions, server health, user retention, and revenue funnels with sub-second chart rendering.','The client had disparate PostgreSQL and ClickHouse databases processing 50M events daily, causing slow query load times and fragmented reporting.','We engineered a centralized aggregation pipeline with Redis caching, Laravel backend, and interactive Chart.js widgets that update via WebSockets.','Dashboard load time dropped from 8.4 seconds to 120 milliseconds; client user retention improved by 45%.','[\"Laravel\",\"Vue.js\",\"Redis\",\"PostgreSQL\",\"Tailwind CSS\",\"Chart.js\"]','https://analytics.example.com',1,1,1,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(2,'Fitness App','fitness-app','Mobile App','FitPulse Global','/assets/images/projects/project-fitness.jpg','Cross-platform fitness app with tracking & analytics.','A sleek, cross-platform mobile application featuring interactive workout routines, heart-rate device pairing, calorie counters, and community social leaderboards.','Existing legacy app had frequent Bluetooth disconnects and poor offline synchronization during workouts.','Re-architected the app with Flutter and an offline-first SQLite sync engine paired with a scalable Laravel API on AWS.','Achieved 4.9-star App Store rating with over 200,000 active monthly subscribers within six months of launch.','[\"Flutter\",\"Dart\",\"Laravel API\",\"Firebase\",\"Stripe\"]','https://fitpulse.example.com',2,1,1,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(3,'Modern E-commerce','modern-e-commerce','E-Commerce','Aura Living','/assets/images/projects/project-ecommerce.jpg','Full-stack e-commerce solution with seamless experience.','A high-converting direct-to-consumer lifestyle commerce platform featuring personalized recommendations, multi-currency pricing, and one-click checkout.','High checkout drop-off rates due to complicated checkout steps and slow image rendering during flash sales.','Built an ultrafast headless store architecture with sub-second edge CDN caching, simplified checkout flow, and automated abandoned cart recovery.','Conversion rate jumped from 1.8% to 4.2%; cart abandonment dropped by 34%.','[\"Laravel\",\"Tailwind CSS\",\"Alpine.js\",\"Stripe\",\"MySQL\",\"Cloudflare\"]','https://auraliving.example.com',3,1,1,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(4,'Project Management Tool','project-management-tool','SaaS Platform','SyncTask Inc','/assets/images/projects/project-saas.jpg','SaaS platform to manage projects, tasks and team efficiency.','An intuitive project management suite enabling agile squads to plan sprints, track time, automate approvals, and collaborate across global timezones.','Scaling WebSocket communication and Kanban drag-and-drop state across thousands of simultaneous remote team members.','Implemented optimistic UI state handling, Redis Pub/Sub WebSocket event channels, and modular board architecture.','Adopted by 350+ technology agencies with 99.98% uptime SLA compliance.','[\"Laravel\",\"Vue.js\",\"WebSockets\",\"Tailwind CSS\",\"Docker\"]','https://synctask.example.com',4,1,1,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(5,'AI Automated Customer Support','ai-automated-customer-support','AI Automation','Nexus Cloud Care','/assets/images/projects/project-ai.jpg','Autonomous customer support agent resolving 65% tickets instantly.','Enterprise conversational AI agent integrated with Zendesk and internal knowledge bases to autonomously answer complex technical customer queries.','Support team overwhelmed by 5,000+ repetitive tier-1 tickets per week with slow first-response times.','Developed custom RAG AI pipeline with vector embedding search, sentiment analysis, and intelligent human agent handoff.','First response time reduced from 4 hours to 12 seconds; ticket resolution satisfaction reached 94%.','[\"Python\",\"OpenAI\",\"Laravel\",\"LangChain\",\"Pinecone\"]','https://nexuscare.example.com',5,0,1,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(6,'Enterprise Health Cloud','enterprise-health-cloud','Web Application','MediCore Health','/assets/images/projects/project-health.jpg','HIPAA-compliant patient portal and telemedicine engine.','Secure telemedicine platform facilitating end-to-end video consultations, encrypted electronic medical records, and digital prescriptions.','Strict healthcare privacy compliance and low-latency video streaming in rural connectivity areas.','Engineered end-to-end encrypted WebRTC streaming, audit-trailed database records, and automated SMS appointment reminders.','Safely processed over 150,000 patient tele-visits with 100% HIPAA audit compliance.','[\"Laravel\",\"WebRTC\",\"MySQL\",\"Tailwind CSS\",\"AWS S3 Vault\"]','https://medicore.example.com',6,0,1,'2026-10-31 08:28:28','2026-10-31 08:28:28');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL DEFAULT 'code',
  `badge` varchar(255) DEFAULT NULL,
  `short_description` text NOT NULL,
  `full_description` longtext NOT NULL,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `benefits` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`benefits`)),
  `tech_stack` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tech_stack`)),
  `order` int(11) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `services_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,'Web Development','web-development','globe','Most Popular','Fast, responsive and scalable web applications built for growth and seamless user experience.','We engineer high-performance web applications that combine stunning visual aesthetics with scalable architecture. From modern single-page applications to enterprise web platforms, our team leverages cutting-edge frameworks like Laravel, Vue, React, and Tailwind CSS to create responsive, secure, and SEO-optimized solutions.','[\"Custom Full-Stack Development\",\"Single Page Applications (SPA)\",\"Progressive Web Apps (PWA)\",\"Responsive UI Across All Devices\",\"Performance & Speed Optimization\",\"Enterprise CMS Solutions\"]','[\"Lightning-fast load times boosting conversion rates\",\"Clean, maintainable, and extensible code architecture\",\"SEO-ready structure to maximize search visibility\",\"Enterprise-grade security and data encryption\"]','[\"Laravel\",\"PHP 8.4\",\"Vue.js\",\"React\",\"Tailwind CSS\",\"MySQL\",\"Redis\"]',1,1,1,NULL,NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(2,'Mobile App Development','mobile-app-development','smartphone','Trending','Cross-platform mobile apps for Android & iOS that users love and engage with daily.','Transform your mobile presence with robust, native-feel iOS and Android applications. We deliver end-to-end mobile engineering from intuitive UX wireframing to App Store and Google Play deployment, utilizing modern cross-platform technologies to cut time-to-market while delivering 60fps performance.','[\"iOS & Android Cross-Platform Apps\",\"Native Performance & Hardware Integration\",\"Offline Mode & Local Data Sync\",\"Push Notifications & User Re-engagement\",\"Biometric Authentication & In-App Purchases\",\"App Store & Play Store Publishing\"]','[\"Single codebase reducing development costs by 40%\",\"Smooth, native animations and ultra-responsive touch\",\"Continuous real-time cloud analytics and crash reporting\",\"Effortless scalability supporting millions of daily active users\"]','[\"Flutter\",\"React Native\",\"Swift\",\"Kotlin\",\"Firebase\",\"RESTful API\"]',2,1,1,NULL,NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(3,'UI/UX Design','ui-ux-design','palette','Creative','Beautiful, user-centric designs that convert visitors into loyal, paying customers.','User experience is at the core of every digital product we construct. Our human-centered design approach marries user psychology, rigorous research, interactive prototyping, and pixel-perfect interface design to turn complex workflows into delightful user journeys.','[\"User Journey Mapping & Persona Research\",\"Interactive Wireframing & Clickable Prototypes\",\"Comprehensive Design Systems & Tokens\",\"Micro-interactions & Motion Design\",\"Accessibility (WCAG 2.1) Compliance\",\"Usability Testing & Feedback Loops\"]','[\"Dramatically increased user engagement and retention\",\"Clear, conversion-focused user navigation journeys\",\"Standardized design system speeding up frontend engineering\",\"Modern, memorable brand impression that outshines competitors\"]','[\"Figma\",\"Adobe XD\",\"Protopie\",\"Tailwind CSS\",\"Storybook\"]',3,1,1,NULL,NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(4,'AI Automation','ai-automation','cpu','AI Powered','AI automation and smart tools for modern businesses looking to scale operations intelligently.','Harness the transformative power of generative AI, large language models, and automated machine workflows. We build intelligent agentic systems, predictive analytics, natural language assistants, and workflow automations that eliminate redundant manual operations.','[\"LLM Integration (OpenAI, Claude, Gemini)\",\"Custom AI Knowledge Bases & RAG Systems\",\"Autonomous Workflow & Task Automations\",\"Intelligent Document & Data Extraction\",\"Predictive Business Intelligence & Analytics\",\"Smart AI Customer Support Agents\"]','[\"Eliminate up to 70% of repetitive operational workloads\",\"24\\/7 intelligent automated customer assistance\",\"Actionable business foresight derived from unstructured data\",\"Safe, private AI setups complying with data governance\"]','[\"Python\",\"OpenAI API\",\"LangChain\",\"FastAPI\",\"Vector DB\",\"PyTorch\"]',4,1,1,NULL,NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(5,'Custom Software Development','custom-software-development','code','Core','Tailored software solutions built from the ground up to solve your unique operational challenges.','Off-the-shelf software rarely addresses the nuanced operational requirements of growing enterprises. We engineer custom bespoke software tailored precisely to your internal processes, compliance constraints, and long-term vision.','[\"Tailored Architecture & Domain Modeling\",\"Microservices & Modular Monoliths\",\"Role-Based Access Control (RBAC)\",\"Auditing, Logging & Security Hardening\",\"Database Optimization & Scalability Planning\",\"Legacy System Modernization & Refactoring\"]','[\"100% intellectual property ownership with zero vendor lock-in\",\"Seamless fit with your proprietary business procedures\",\"Built to scale seamlessly without recurring per-seat fees\",\"Comprehensive documentation and developer handoff\"]','[\"Laravel\",\"PostgreSQL\",\"Docker\",\"Kubernetes\",\"GraphQL\",\"AWS\"]',5,1,1,NULL,NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(6,'API Integration','api-integration','git-merge','Connectivity','Seamless third-party API integration and robust custom RESTful and GraphQL API development.','Connect fragmented software ecosystems into cohesive operational powerhouses. We architect secure, documented, and resilient APIs while connecting your platforms to external payment gateways, CRM systems, shipping providers, and marketing engines.','[\"RESTful & GraphQL API Architecture\",\"Secure OAuth2 & JWT Authentication\",\"Stripe, PayPal & Razorpay Payment Integrations\",\"ERP, CRM & Webhook Automation\",\"Rate Limiting & DDOS Throttling\",\"Comprehensive OpenAPI \\/ Swagger Documentation\"]','[\"Eliminate data silos between software tools\",\"Instant real-time data sync across platforms\",\"High-throughput fault tolerance with queue retries\",\"Developer-friendly developer portal and mock sandbox\"]','[\"REST\",\"GraphQL\",\"Webhooks\",\"OAuth2\",\"Stripe\",\"Twilio\",\"Zapier\"]',6,0,1,NULL,NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(7,'Business Management Software','business-management-software','briefcase','Enterprise','Integrated ERP, CRM, and inventory management systems designed for operational excellence.','Equip your leadership and departments with unified business intelligence and operational command. We design custom ERP, HRM, invoicing, inventory tracking, and client management systems tailored to streamline team collaboration.','[\"Custom CRM & Sales Pipeline Management\",\"Multi-Warehouse Inventory & Supply Chain Tracking\",\"Automated Invoicing & Financial Accounting\",\"HRM, Payroll & Employee Attendance Portals\",\"Executive Analytics & Real-Time Reporting\",\"Multi-Branch & Multi-Currency Capability\"]','[\"Consolidate 5+ fragmented apps into one unified dashboard\",\"Drastically reduce human data entry errors\",\"Real-time transparency on revenue, costs, and inventory\",\"Automate recurring approvals and task assignments\"]','[\"Laravel\",\"MySQL\",\"Livewire\",\"Tailwind CSS\",\"Chart.js\",\"Export Tools\"]',7,0,1,NULL,NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(8,'E-commerce Development','e-commerce-development','shopping-cart','High ROI','Full-stack e-commerce solutions with frictionless checkout, inventory sync, and maximum conversions.','Build high-converting digital storefronts crafted for speed, trust, and frictionless mobile purchasing. From bespoke multi-vendor marketplaces to custom WooCommerce and Shopify Plus extensions, we ensure each click drives revenue.','[\"Frictionless One-Click Checkout Architecture\",\"Multi-Currency & Multilingual Localization\",\"Inventory Sync & Order Fulfillment Automation\",\"Discount Engines & Customer Loyalty Programs\",\"Abandoned Cart Recovery Automation\",\"Payment Gateway Integration (Stripe, Apple Pay, Google Pay)\"]','[\"Significant reduction in shopping cart drop-offs\",\"Sub-second product catalog search & faceted filters\",\"Omnichannel inventory synchronization\",\"PCI-DSS compliant payment processing security\"]','[\"Laravel\",\"Shopify Plus\",\"WooCommerce\",\"Stripe\",\"Tailwind CSS\",\"Algolia\"]',8,0,1,NULL,NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(9,'Website Maintenance & Support','website-maintenance-support','shield-check','24/7 Support','Proactive monitoring, security patching, cloud backups, and performance fine-tuning.','Keep your digital flagship operating at peak performance around the clock. Our dedicated maintenance engineers provide proactive uptime monitoring, automated cloud backups, SSL certification, vulnerability patching, and SLA-backed emergency responses.','[\"24\\/7 Automated Uptime & Error Alerting\",\"Daily Encrypted Off-Site Backups\",\"Core Framework & Security Patch Updates\",\"Database Performance Tuning & Indexing\",\"Malware Scanning & Web Application Firewall\",\"Dedicated SLA Support & Feature Enhancements\"]','[\"99.9% guaranteed uptime assurance\",\"Zero business interruption from unexpected crashes\",\"Guaranteed rapid response from senior engineers\",\"Continuous optimization keeping your site ahead of curves\"]','[\"AWS CloudWatch\",\"Sentry\",\"Cloudflare\",\"GitHub Actions\",\"Docker\"]',9,0,1,NULL,NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
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
INSERT INTO `sessions` VALUES ('fMNTCPCX6W5eJKJW2xP4JeEW3VP8a6GkmLJi5Zgx',NULL,'127.0.0.1','curl/8.7.1','eyJfdG9rZW4iOiJDVnV2SkZGNUxBTUJkN0thcllDUVlkV3dsa0UzV0ZEUkMwcVl4VGhYIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1794429816),('ieDzmkxgs3lsqd60b0DikBjepi4ALrtAEvNiHNFf',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36','eyJfdG9rZW4iOiI1ZGV2eUtNc0JEUUk5eDV3V0E1eGJhdktLYWpxZVRvYzRaaGZRQVExIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9jb250YWN0Iiwicm91dGUiOiJjb250YWN0In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1794430476);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testimonials`
--

DROP TABLE IF EXISTS `testimonials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `testimonials` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_name` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `content` text NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
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
INSERT INTO `testimonials` VALUES (1,'Rohit Sharma','CEO','D2C Startup','/assets/images/testimonials/avatar-1.jpg',5,'UpPage Technology transformed our idea into a powerful digital product. Their team is professional, creative and super responsive. They delivered well ahead of schedule and the code quality is top-notch.',1,1,1,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(2,'Anjali Verma','Product Manager','FinScale Systems','/assets/images/testimonials/avatar-2.jpg',5,'Amazing experience from start to finish. They delivered on time and the quality exceeded our expectations. The attention to detail in UX design and backend stability made all the difference.',2,1,1,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(3,'Vikram Patel','Founder','SaaS Company','/assets/images/testimonials/avatar-3.jpg',5,'Their attention to detail and technical expertise is outstanding. Highly recommended! We have partnered with them on 4 consecutive product launches and each has been a major commercial success.',3,1,1,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(4,'Sarah Jenkins','VP of Engineering','CloudScale Global','/assets/images/testimonials/avatar-4.jpg',5,'UpPage Technology is the most dependable engineering partner we have ever contracted with. Clean Laravel architecture, prompt communication, and zero technical debt. Truly world-class.',4,0,1,'2026-10-31 08:28:28','2026-10-31 08:28:28');
/*!40000 ALTER TABLE `testimonials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'admin',
  `phone` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
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
INSERT INTO `users` VALUES (1,'Admin UpPage','admin@uppage.tech',NULL,'$2y$12$fHrFgoE5wWU/aWPn5C36GeZtNNNCs/C2Ho32M0NeHFNGVuU98hqHi','admin','+1 (555) 019-2834',NULL,'ZkJLOqNEgUiIwjs7Y5JZo7G1rhOckDsJC1gSWoQHRUoawmeIn26A9ka3ovbS','2026-10-31 08:28:28','2026-10-31 08:28:28'),(2,'Lead Engineer','admin@craftbycode.com',NULL,'$2y$12$PqlT6AqB/3qZ9JEgCbcHZOnAn55dtsg1a26KRmK7hU603snzBy5tO','admin','+1 (555) 019-2835',NULL,NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `website_settings`
--

DROP TABLE IF EXISTS `website_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `website_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `key` varchar(255) NOT NULL,
  `value` longtext DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'text',
  `label` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `website_settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `website_settings`
--

LOCK TABLES `website_settings` WRITE;
/*!40000 ALTER TABLE `website_settings` DISABLE KEYS */;
INSERT INTO `website_settings` VALUES (1,'general','brand_name','UpPage Technology','text','Brand Name',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(2,'general','brand_tagline','Building Digital Solutions. Empowering Businesses.','text','Brand Tagline',NULL,'2026-10-31 08:28:28','2026-10-31 10:12:43'),(3,'general','site_description','UpPage Technology is a premium software development and digital solutions company crafting custom web applications, mobile apps, and AI automation for global enterprises.','textarea','Site Description',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(4,'general','brand_badge','TRUSTED BY STARTUPS & BUSINESSES WORLDWIDE','text','Hero Badge Text',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(5,'hero','hero_headline_1','WE DESIGN.','text','Hero Line 1',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(6,'hero','hero_headline_2','WE CODE.','text','Hero Line 2',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(7,'hero','hero_headline_gradient','WE INNOVATE.','text','Hero Highlight / Gradient Line',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(8,'hero','hero_subtitle','We build custom digital products, AI automation tools, and MVPs that help startups and businesses grow faster.','textarea','Hero Subtitle',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(9,'hero','hero_cta_primary_text','Explore Services','text','Hero Primary Button Text',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(10,'hero','hero_cta_primary_url','/services','text','Hero Primary Button Link',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(11,'hero','hero_cta_secondary_text','Let\'s Talk','text','Hero Secondary Button Text',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(12,'hero','hero_cta_secondary_url','/contact','text','Hero Secondary Button Link',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(13,'stats','stat_clients_count','50+','text','Happy Clients Count',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(14,'stats','stat_clients_label','Happy Clients','text','Happy Clients Label',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(15,'stats','stat_projects_count','120+','text','Projects Completed Count',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(16,'stats','stat_projects_label','Projects Completed','text','Projects Completed Label',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(17,'stats','stat_years_count','5+','text','Years Experience Count',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(18,'stats','stat_years_label','Years Experience','text','Years Experience Label',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(19,'stats','stat_satisfaction_count','98%','text','Client Satisfaction Rate',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(20,'stats','stat_satisfaction_label','Client Satisfaction','text','Client Satisfaction Label',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(21,'contact','contact_email','hello@uppage.tech','text','Company Email',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(22,'contact','contact_phone','+1 (555) 019-2834','text','Company Phone',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(23,'contact','contact_address','100 Innovation Way, Suite 400, San Francisco, CA 94105','text','Company Address',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(24,'contact','contact_hours','Monday - Friday: 9:00 AM - 6:00 PM EST','text','Working Hours',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(25,'contact','google_maps_url','https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.0863816568285!2d-122.39997232348573!3d37.78802271168436!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80858062828b8c73%3A0x6b63d91cf3241bc3!2sMarket%20St%2C%20San%20Francisco%2C%20CA!5e0!3m2!1sen!2sus!4v1710000000000!5m2!1sen!2sus','textarea','Google Maps Embed URL',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(26,'social','social_linkedin','https://linkedin.com/company/uppage-technology','text','LinkedIn URL',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(27,'social','social_twitter','https://x.com/uppagetech','text','Twitter/X URL',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(28,'social','social_github','https://github.com/uppagetech','text','GitHub URL',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(29,'social','social_facebook','https://facebook.com/uppagetech','text','Facebook URL',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(30,'cta','cta_title','Let\'s build something amazing together','text','Call To Action Title',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(31,'cta','cta_subtitle','Have a project in mind? Let\'s turn your idea into reality.','text','Call To Action Subtitle',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(32,'cta','cta_button_text','Start a Project','text','Call To Action Button Text',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(33,'cta','cta_button_url','/contact','text','Call To Action Button URL',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(34,'seo','meta_title_default','UpPage Technology | Building Digital Solutions. Empowering Businesses.','text','Default Meta Title',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(35,'seo','meta_description_default','UpPage Technology creates custom software, responsive web applications, mobile apps, and AI automations that scale businesses.','textarea','Default Meta Description',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28'),(36,'seo','meta_keywords_default','software development, web design, mobile apps, AI automation, custom software, digital solutions','text','Default Meta Keywords',NULL,'2026-10-31 08:28:28','2026-10-31 08:28:28');
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

-- Dump completed on 2026-11-12  2:24:53
