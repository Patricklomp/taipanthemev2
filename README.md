# Taipan Minimal

Minimalist WordPress theme for [taipan.ee](https://taipan.ee): guide services on Saaremaa, Muhu and Kuressaare, plus business consulting.

The theme lives in `wp-theme/taipan-minimal`. Plain PHP, CSS and JS, no build tooling.

## Build

1. Bump `Version` in `wp-theme/taipan-minimal/style.css`.
2. Zip the theme folder:

   ```sh
   cd wp-theme
   rm -f taipan-minimal.zip
   zip -r taipan-minimal.zip taipan-minimal -x '*/.*'
   ```

3. Upload `taipan-minimal.zip` in WordPress under **Appearance → Themes → Add New → Upload Theme**.
