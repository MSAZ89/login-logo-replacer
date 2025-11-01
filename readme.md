# Login Logo Replacer

A simple yet powerful WordPress plugin that allows you to replace the default WordPress login logo with your own custom image from the media library.

![WordPress](https://img.shields.io/badge/WordPress-5.0%2B-blue)
![PHP](https://img.shields.io/badge/PHP-7.4%2B-purple)
![License](https://img.shields.io/badge/License-GPL%20v2-green)

## Features

✨ **Easy to Use** - Simple settings page with intuitive controls

🖼️ **Media Library Integration** - Choose any image from your WordPress media library

👁️ **Live Preview** - See your selected logo in the settings page before saving

🔗 **Custom Link URL** - Set where the logo links to (homepage, company site, etc.)

🆕 **Open in New Tab** - Option to open logo link in a new browser tab

⚡ **Lightweight** - Clean, efficient code with no bloat

🎨 **Automatic Sizing** - Handles logo dimensions automatically while maintaining aspect ratio

## Installation

### Method 1: Manual Installation

1. Download the plugin files
2. Upload the `login-logo-replacer` folder to `/wp-content/plugins/`
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Go to Settings → Login Logo to configure

### Method 2: WordPress Admin

1. Download the plugin as a ZIP file
2. Go to Plugins → Add New → Upload Plugin
3. Choose the ZIP file and click Install Now
4. Activate the plugin
5. Go to Settings → Login Logo to configure

## Usage

### Setting Up Your Custom Logo

1. Navigate to **Settings → Login Logo** in your WordPress admin
2. Click **Select Image** to open the media library
3. Choose an image or upload a new one
4. Click **Use this image**
5. (Optional) Enter a custom URL in the **Logo Link URL** field
6. (Optional) Check **Open link in new tab** if desired
7. Click **Save Changes**

### Recommended Image Specifications

- **Format:** PNG, JPG, or SVG
- **Dimensions:** 320x320 pixels or smaller
- **Aspect Ratio:** Square or landscape works best
- **File Size:** Keep under 200KB for optimal loading

## Screenshots

### Settings Page

The clean and intuitive settings interface where you can:

- Select your custom logo from the media library
- Preview your selected logo
- Set custom link URL
- Choose link behavior (same tab or new tab)

### Login Page

Your customized login page with:

- Your branded logo
- Custom link destination
- Professional appearance

## File Structure

```
login-logo-replacer/
├── login-logo-replacer.php    # Main plugin file
├── admin.js                    # JavaScript for media uploader
├── admin.css                   # Admin styling
└── README.md                   # This file
```

## Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- Modern browser with JavaScript enabled

## Frequently Asked Questions

### How do I change the logo?

Go to Settings → Login Logo, click "Change Image", select a new image, and save.

### Can I remove the logo and go back to the WordPress default?

Yes! Just click the "Remove Image" button and save. The default WordPress logo will return.

### What happens if I delete the image from my media library?

The plugin will gracefully fall back to the default WordPress logo.

### Can I use a transparent PNG?

Absolutely! Transparent PNGs work great and look professional on the login page.

### Does this affect my site's performance?

No. The plugin is lightweight and only loads on the login page and its settings page.

### Can I link to an external website?

Yes! Enter any valid URL in the Logo Link URL field, including external websites.

## Changelog

### Version 1.0.1

- Added custom URL link functionality
- Added "Open in new tab" option
- Added Settings link on plugins page
- Improved code documentation

### Version 1.0.0

- Initial release
- Media library integration
- Logo replacement functionality
- Automatic image sizing

## Developer Notes

### Hooks & Filters

The plugin uses the following WordPress hooks:

- `login_enqueue_scripts` - Inject custom logo CSS
- `login_headerurl` - Modify logo link URL
- `login_headertext` - Modify logo link title

### Extending the Plugin

You can extend this plugin using WordPress filters:

```php
// Programmatically set logo URL
add_filter('login_headerurl', function($url) {
    return 'https://your-custom-url.com';
});

// Programmatically set logo title
add_filter('login_headertext', function($title) {
    return 'Your Custom Title';
});
```

## Support

For bug reports and feature requests, please open an issue on GitHub.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This plugin is licensed under the GPL v2 or later.

```
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
```

## Credits

Developed with ❤️ for the WordPress community

## Roadmap

Planned features for future releases:

- Custom login page background
- Custom button styling
- Live preview functionality
- Login page template presets
- Mobile-specific logo settings

---

**Made for WordPress** | [Report Bug](https://github.com/yourusername/login-logo-replacer/issues) | [Request Feature](https://github.com/yourusername/login-logo-replacer/issues)
