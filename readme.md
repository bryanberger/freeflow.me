##How to install
### Step 1: Get the code
#### Option 1: Git Clone

	git clone git://github.com/decapyre/freeflow.me.git freeflow.me

### Step 2: Use Composer to install dependencies
#### Option 1: Composer is not installed globally

    cd freeflow.me
	curl -s http://getcomposer.org/installer | php
	php composer.phar install --dev
#### Option 2: Composer is installed globally

    cd freeflow.me
	composer install --dev


### Step 3: nodejs & npm install (get node/npm)
	npm install
	

### Step 4: To build the css from less files run (get grunt)
	grunt


### How to add columns to existing tables
	php artisan migrate:make add_column_name_to_xyz_table
	fill in the schema
	php artisan migrate