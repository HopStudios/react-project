# React Project Builder

## Getting started

You can use this builder in your local site built with docker, or on a remote server. You need to have `npm` installed.

1. `mkdir add-on-builder` in the root directory if not exist.
2. `cd add-on-builder` and `git clone` this project

## Initialize

In your directory,
```
npm install
```
to install all the packages.
```
npm copy
```
to copy the files to the `system/user/addons` and `themes/user`. If you've modified the locations of your add-ons folder and/or themes folder, place adjust the paths in `config/paths.js`.

When you are ready to start working on the React app,
```
npm run watch
```
and start working in the `src` directory and `system/user/addons/react_project` files.

## Deployment

You need to change `react_project` to your own add-on's path in `config/paths.js`.

```
npm run build
```

Distribute the `dist/` files.