# Pascal Sommer Photography website

[My photography blog](https://photography.pascalsommer.ch), now written in Laravel

## Development

The js and sass source files are located in `laravel/resources/`, and the generated output will go to the `/js`, `/css`, and `/fonts` directories. To compile, type:

```bash
cd laravel
yarn
npm run prod
```

Note that `/js/keyboardShortcuts.js` and `/js/setPhotoDimensions.js` are currently not generated, but rather developed there in place. This will hopefully change soon(ish).

## Todo
- [ ] pagination: jump to start/end
- [ ] visual indication for tags that reduce the nr. of results to zero when selected
- [x] random photo button
- [ ] check if we can actually entirely remove the dependency on eloquent-sortable
- [ ] test blacklist (see error at 2018-05-12 21:19:36, unexpected '->' at BlacklistController.php:40)
- [x] clean up css
- [ ] generate keyboardShortcuts.js and setPhotoDimensions.js through typescript
- [x] replace default laravel login page with something fitting the overall design
- [ ] remove path from filename in photos table
- [ ] store photo dimensions in db or cache them somewhere
- [ ] thumbnails for gallery and staging view -- will probably require GD
- [ ] remove exif from photos
- [ ] reencode images with progressive jpg
- [ ] replace uploaded photo from file, keeping all other data
- [ ] add alt-text according to [these guidelines](https://axesslab.com/alt-texts/) to photos, add alt-text missing filter to staging view
- [ ] maybe change how the filters work in staging view
- [ ] pagination for staging view?
- [ ] check if title is unique in "new post" frontend via some js or something like that
- [x] get old frontends of the website to work with the current database
- [x] tag filter reset button
- [x] clean up photo view page, e.g. spacing around tags and description, back to overview button. Description could look like a comment (copying a bit of instagram's aesthetic), also make sure to use the horizontal space.
- [ ] add location information to photos?
- [ ] make posts page load quicker
