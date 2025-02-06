CREATE TABLE IF NOT EXISTS "migrations"(
  "id" integer primary key autoincrement not null,
  "migration" varchar not null,
  "batch" integer not null
);
CREATE TABLE IF NOT EXISTS "users"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "email" varchar not null,
  "email_verified_at" datetime,
  "password" varchar not null,
  "remember_token" varchar,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "users_email_unique" on "users"("email");
CREATE TABLE IF NOT EXISTS "password_reset_tokens"(
  "email" varchar not null,
  "token" varchar not null,
  "created_at" datetime,
  primary key("email")
);
CREATE TABLE IF NOT EXISTS "sessions"(
  "id" varchar not null,
  "user_id" integer,
  "ip_address" varchar,
  "user_agent" text,
  "payload" text not null,
  "last_activity" integer not null,
  primary key("id")
);
CREATE INDEX "sessions_user_id_index" on "sessions"("user_id");
CREATE INDEX "sessions_last_activity_index" on "sessions"("last_activity");
CREATE TABLE IF NOT EXISTS "cache"(
  "key" varchar not null,
  "value" text not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE TABLE IF NOT EXISTS "cache_locks"(
  "key" varchar not null,
  "owner" varchar not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE TABLE IF NOT EXISTS "jobs"(
  "id" integer primary key autoincrement not null,
  "queue" varchar not null,
  "payload" text not null,
  "attempts" integer not null,
  "reserved_at" integer,
  "available_at" integer not null,
  "created_at" integer not null
);
CREATE INDEX "jobs_queue_index" on "jobs"("queue");
CREATE TABLE IF NOT EXISTS "job_batches"(
  "id" varchar not null,
  "name" varchar not null,
  "total_jobs" integer not null,
  "pending_jobs" integer not null,
  "failed_jobs" integer not null,
  "failed_job_ids" text not null,
  "options" text,
  "cancelled_at" integer,
  "created_at" integer not null,
  "finished_at" integer,
  primary key("id")
);
CREATE TABLE IF NOT EXISTS "failed_jobs"(
  "id" integer primary key autoincrement not null,
  "uuid" varchar not null,
  "connection" text not null,
  "queue" text not null,
  "payload" text not null,
  "exception" text not null,
  "failed_at" datetime not null default CURRENT_TIMESTAMP
);
CREATE UNIQUE INDEX "failed_jobs_uuid_unique" on "failed_jobs"("uuid");
CREATE TABLE IF NOT EXISTS "categories"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE TABLE IF NOT EXISTS "options"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "additional_price" numeric not null default '0',
  "product_id" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("product_id") references "products"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "products"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "price" numeric not null,
  "description" text,
  "active" tinyint(1) not null default '1',
  "category_id" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("category_id") references "categories"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "product_images"(
  "id" integer primary key autoincrement not null,
  "product_id" integer not null,
  "image_path" varchar not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("product_id") references "products"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "inventory_items"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "description" text,
  "cost_per_unit" numeric not null,
  "stock_quantity" integer not null default('0'),
  "created_at" datetime,
  "updated_at" datetime,
  "storage_unit" varchar not null default 'pieces',
  "usage_unit" varchar not null default 'pieces',
  "conversion_factor" numeric not null default '1',
  "min_stock" numeric,
  "low_stock_alert_sent" tinyint(1) not null default '0'
);
CREATE TABLE IF NOT EXISTS "inventory_item_product"(
  "id" integer primary key autoincrement not null,
  "product_id" integer not null,
  "inventory_item_id" integer not null,
  "quantity_used" numeric not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("inventory_item_id") references inventory_items("id") on delete no action on update no action,
  foreign key("product_id") references products("id") on delete no action on update no action
);
CREATE TABLE IF NOT EXISTS "order_items"(
  "id" integer primary key autoincrement not null,
  "order_id" integer not null,
  "product_id" integer not null,
  "quantity" integer not null,
  "price" numeric not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("order_id") references "orders"("id") on delete cascade,
  foreign key("product_id") references "products"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "orders"(
  "id" integer primary key autoincrement not null,
  "customer_id" integer,
  "order_number" varchar not null,
  "status" varchar not null default 'initialized',
  "total_amount" numeric not null,
  "created_at" datetime,
  "updated_at" datetime,
  "customer_name" varchar,
  "customer_phone" varchar,
  foreign key("customer_id") references "customers"("id") on delete cascade
);
CREATE UNIQUE INDEX "orders_order_number_unique" on "orders"("order_number");
CREATE TABLE IF NOT EXISTS "customers"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "phone" varchar not null,
  "created_at" datetime,
  "updated_at" datetime
);

INSERT INTO migrations VALUES(1,'0001_01_01_000000_create_users_table',1);
INSERT INTO migrations VALUES(2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO migrations VALUES(3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO migrations VALUES(4,'2025_01_24_184824_create_categories_table',2);
INSERT INTO migrations VALUES(5,'2025_01_24_184824_create_options_table',2);
INSERT INTO migrations VALUES(6,'2025_01_24_184824_create_products_table',2);
INSERT INTO migrations VALUES(7,'2025_01_25_183452_create_product_images_table',3);
INSERT INTO migrations VALUES(10,'2025_01_27_175704_create_inventory_items_table',4);
INSERT INTO migrations VALUES(11,'2025_01_27_175749_create_inventory_item_product_table',4);
INSERT INTO migrations VALUES(12,'2025_01_27_190951_update_inventory_items_table',5);
INSERT INTO migrations VALUES(13,'2025_01_27_191119_update_inventory_item_product_table',5);
INSERT INTO migrations VALUES(14,'2025_01_27_193441_add_low_stock_columns_to_inventory_items',6);
INSERT INTO migrations VALUES(15,'2025_01_29_121714_create_order_items_table',7);
INSERT INTO migrations VALUES(16,'2025_01_29_121714_create_orders_table',7);
INSERT INTO migrations VALUES(17,'2025_01_29_121715_create_customers_table',7);
INSERT INTO migrations VALUES(18,'2025_02_01_114828_create_customers_table',8);
