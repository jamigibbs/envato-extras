# Description

This WordPress plugin enables an Envato Extras post type and shortcode for easier management of projects created using the Envato API.

# TODO
- [ ] Display author avatar with Envato API
- [ ] Localize
- [ ] 'Load more' in sections
- [ ] Section Sorting / Navigation
- [ ] Lazy load images
- [ ] Section navigation

# Usage

When activated, an admin menu section called `Envato Extras` will be available. Here you can enter individual Extras for display:

![Image of admin menu](http://envato.d.pr/QCrsIF/29v4gA11+)

Select "Add New" to begin adding individuals posts:

![Custom post screen](http://envato.d.pr/mILDYQ/5Vm7sPPd+)

A number of meta fields are available for each post:

![Custom post meta section](http://envato.d.pr/yjuh2r/5SDNI5t1+)

Once created, use the available shortcodes to display the content.

To display an entire category group:

`[envato_extras_category header="Web Apps" cat="web-apps" ]`

To display individual posts:

`[envato_extras_single header="Featured" post="149, 160, 108"]`

Example display:

![Sample page display](http://envato.d.pr/VRsi5t/4TIzt7RX+)

# Changelog

## [0.1.3] - 2017-07-12
- Removes the "New Page Link" plugin filter.

## [0.1.2] - 2017-07-12
- The post title now links to the external project instead of internal post
- Filter 'envato-market-extras' page so that links don't open in a new page.

## [0.1.1] - 2017-07-11
- Fixing admin area icon

## [0.1.0] - 2017-07-11
- Initial release
