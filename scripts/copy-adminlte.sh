#!/usr/bin/env bash
set -euo pipefail

# Copies AdminLTE and common plugins from node_modules to public/vendor/adminlte
ROOT_DIR="$(cd "$(dirname "$0")/.." && pwd)"
PUBLIC_DIR="$ROOT_DIR/public/vendor/adminlte"

echo "Preparing $PUBLIC_DIR"
mkdir -p "$PUBLIC_DIR/dist"
mkdir -p "$PUBLIC_DIR/plugins"

copy_if_exists() {
  local src="$1"
  local dst="$2"
  if [ -e "$src" ]; then
    echo "Copying $src -> $dst"
    mkdir -p "$(dirname "$dst")"
    cp -r "$src" "$dst"
  else
    echo "Warning: $src not found, skipping"
  fi
}

# AdminLTE core
copy_if_exists "$ROOT_DIR/node_modules/admin-lte/dist" "$PUBLIC_DIR/dist"

# FontAwesome
copy_if_exists "$ROOT_DIR/node_modules/@fortawesome/fontawesome-free" "$PUBLIC_DIR/plugins/fontawesome-free"

# overlayscrollbars (used by admin-lte)
copy_if_exists "$ROOT_DIR/node_modules/overlayscrollbars" "$PUBLIC_DIR/plugins/overlayscrollbars"

# DataTables (optional)
copy_if_exists "$ROOT_DIR/node_modules/datatables.net-bs5/css" "$PUBLIC_DIR/plugins/datatables/css"
copy_if_exists "$ROOT_DIR/node_modules/datatables.net-bs5/js" "$PUBLIC_DIR/plugins/datatables/js"

# Summernote (optional)
copy_if_exists "$ROOT_DIR/node_modules/summernote/dist" "$PUBLIC_DIR/plugins/summernote"

# FullCalendar (optional) - copy core if installed
copy_if_exists "$ROOT_DIR/node_modules/@fullcalendar/core/main.css" "$PUBLIC_DIR/plugins/fullcalendar/main.css"
copy_if_exists "$ROOT_DIR/node_modules/@fullcalendar/core/main.js" "$PUBLIC_DIR/plugins/fullcalendar/main.js"

echo "AdminLTE asset copy complete. Verify files under $PUBLIC_DIR"
