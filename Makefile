up:
	./vendor/bin/sail up -d
down:
	./vendor/bin/sail down
css:
	./vendor/bin/sail npm run build
mig:
	./vendor/bin/sail php artisan migrate