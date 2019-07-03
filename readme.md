# Pascal Sommer Photography website

My personal website, now written in Laravel

## Development

The js and sass source files are located in `laravel/resources/assets/`, and the generated output will go to the `/js`, `/css`, and `/fonts` directories. To compile, type:

```bash
yarn
npm run prod
```

Note that `/js/arrowNavigate.js` and `/js/setPhotoDimensions.js` are currently not generated, but rather developed there in place. This will hopefully change soon(ish).

## Todo
- [x] clean up css
- [ ] generate arrowNavigate.js and setPhotoDimensions.js through typescript
- [ ] replace default laravel login page with something fitting the overall design
- [ ] remove path from filename in photos table
- [ ] thumbnails for gallery and staging view -- will probably require GD
- [ ] remove exif from photos
- [ ] replace uploaded photo from file, keeping all other data
- [ ] add alt-text according to [these guidelines](https://axesslab.com/alt-texts/) to photos, add alt-text missing filter to staging view
- [ ] maybe change how the filters work in staging view
- [ ] pagination for staging view?
- [ ] check if title is unique in "new post" frontend via some js or something like that
- [x] get old frontends of the website to work with the current database
- [x] tag filter reset button
- [ ] unify look of description with comments
- [ ] clean up photo view page, e.g. spacing around tags and description, back to overview button
- [ ] add location information to photos?
- [ ] make posts page load quicker
