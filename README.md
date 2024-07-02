# Serlo moodle integration

This plugin adds a serlo activity to moodle

## Development

This plugin uses the @serlo/editor-web-component npm package which need to be bundled to be used correctly by moodle.

The package.json includes a `build` script which bundles the package and runs the moodle grunt task to generate the file used by moodle.

Since the complete task takes some time you might want to use the `npx grunt watch` task in the moodle root directory.

To make this work, you have to patch the watch task to not run the eslint stage:

```js
//moodle/.grunt/tasks/javascript.js
- 189 tasks: ['amd']
+ 189 tasks: ['rollup']
```

Also you need the `watchman` binary to be present in your path: See [here](https://facebook.github.io/watchman/docs/install.html) on how to get it.

> If this binary is missing grunt may mistakenly throw the "Watchman CLI is installed but failed due to permission errors" error.

then you can start `npx grunt watch` in the moodle root dir.

Afterwards start the `watch` script out of the serlo plugin dir to start esbuild in watch mode.
