all: tests apidocs phpmd

apidocs: force
	vendor/bin/apigen generate -s src -d build/apidocs

phpmd: force
	vendor/bin/phpmd src/ text cleancode,codesize,controversial,design,naming,unusedcode > build/phpmd_result.txt

tests: force
	vendor/bin/phpunit

clean:
	rm -r build/*

force:
