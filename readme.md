# Content Layout Control Demo Theme

This theme demonstrates how to integrate the [content-layout-control](https://github.com/NateWr/content-layout-control) framework in your theme.

So far it only demonstrates a very basic integration, using the two components provided by default.

## Install

The simple way is to download the [latest release package](https://github.com/NateWr/clc-demo-theme/releases) and install it as you would any other theme. Once activated, open any Page in the Customizer and look for the **Content Layout Control** section.

If you want to build from source:

```
git clone --recursive https://github.com/NateWr/clc-demo-theme.git
cd clc-demo-theme/lib/content-layout-control
npm install
grunt build
```

## Plans

- Add a custom component
- Extend a component
- Using the secondary panel in a custom component
- More complex `active_callback` logic
- Disable the post editor to prevent data bleed
- Maybe write a tutorial or something that explains better what the code is doing
- Doing crazier things, like extending the control itself, not saving to `post_content`, running two controls at once, etc.

## Example

Here's a [user-facing demo video](https://www.youtube.com/watch?v=jAEyQHQsDGE) showing a fleshed out implementation in the [Luigi theme](http://themeofthecrop.com/theme/luigi/).
