## Makefile - helper targets for AdminLTE asset installation
.PHONY: help adminlte-install adminlte-copy

help:
	@echo "Usage: make <target>"
	@echo "Targets:"
	@echo "  adminlte-install   Install npm deps and copy AdminLTE assets to public/vendor/adminlte"
	@echo "  adminlte-copy      Copy AdminLTE assets from node_modules to public/vendor/adminlte"

adminlte-install:
	npm run adminlte:install

adminlte-copy:
	npm run adminlte:copy
