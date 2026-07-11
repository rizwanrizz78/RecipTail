# Recipe Magazine (RecipTail Diner Theme) - Premium WordPress Theme

A premium-quality WordPress recipe blog theme with a warm vintage diner menu board aesthetic. Built with pure PHP, HTML5, CSS3, Vanilla JS, and native WordPress features.

## 1. Theme Installation

1. Download the `recipe-magazine` folder or `.zip` file.
2. In your WordPress admin dashboard, navigate to **Appearance > Themes**.
3. Click **Add New**, then **Upload Theme**.
4. Choose the `.zip` file and click **Install Now**.
5. Once installed, click **Activate**.

## 2. Global Customizer Settings

Go to **Appearance > Customize**:
- **Social Media Links:** Enter URLs for Instagram, Pinterest, Facebook, etc. The icons will automatically appear in the top bar and footer.
- **Popular Recipes Settings:** Define how many popular posts to show on the homepage grid.
- **Disclosure Settings:** Enter your standard affiliate disclosure text (e.g., "This post contains affiliate links...") which is automatically output anywhere you use the `[rt_disclosure]` shortcode.

## 3. Creating Recipe Posts (The Shortcode System)

This theme uses a completely code-free shortcode architecture to build perfectly styled magazine layouts natively in the Gutenberg editor. Do not use block page builders — just type paragraphs and drop in these shortcodes.

### Post Headers & Disclosures
At the top of your post, type:

```
[rt_eyebrow]LABOR DAY • BBQ FOR A CROWD[/rt_eyebrow]
[rt_dek]Nine crowd-tested recipes for the last big cookout of summer.[/rt_dek]
[rt_disclosure position="top"]
```
*(The theme automatically inserts your Featured Image directly below this top disclosure to match the design flow).*

### Recipe Cards
To add a beautiful recipe card, wrap your content like this:

```
[rt_recipe number="1" title="Classic Smash Burger Bar" prep="15 min" cook="10 min" serves="12"]

[rt_blurb]Crispy-edged smash burgers with a build-your-own toppings station.[/rt_blurb]

[rt_ingredients]
- 4 lbs 80/20 ground beef
- 12 burger buns
- 12 slices American cheese
- Salt and pepper
[/rt_ingredients]

[rt_instructions]
1. Portion beef into 3 oz balls. Do not season yet.
2. Heat griddle very hot. Smash balls flat immediately with a spatula.
3. Season, cook 2 minutes, flip, add cheese, cook 1 more minute.
[/rt_instructions]

[rt_tip]Cook in batches of 4-5 patties so the griddle stays hot enough to sear.[/rt_tip]

[/rt_recipe]
```
*Note: JSON-LD SEO Schema is generated automatically for every `[rt_recipe]` block.*

### Affiliate Promos & Decorators
Add a CTA box or section divider anywhere:

```
[rt_divider]

[rt_cta label="GRILLING GEAR THAT MAKES THIS EASIER" title="The Tool Set Behind Every Recipe Here" button="SHOP THE SET" link="https://amzn.to/XXXX"]
A good instant-read thermometer takes the guesswork out.
[/rt_cta]
```

### Outro / Fine Print
At the end of your post:

```
[rt_outro title="Your Menu, Sorted"]
Prep the salads ahead and the grill only has to handle burgers.
[/rt_outro]

[rt_disclosure position="bottom"]
```

## 4. Native Gutenberg Styling

Any text typed outside a shortcode is automatically styled as the vintage magazine body copy:
- **Paragraphs** are neatly spaced.
- **Heading 2 blocks** get the bold Bebas Neue treatment.
- **Quote blocks** automatically become highlighted tip callouts with a brick-colored border.
- **List blocks** are styled to match.

## 5. Homepage Featuring

To feature a post in the large hero grid on the homepage, check the **"Mark as Featured Article"** checkbox in the right sidebar of the post editor.

## 6. Recommended Image Sizes

- **Featured Hero / Recipe Images:** 1200x800px (3:2 aspect ratio).
- **Archive Grid Cards:** 600x800px (Portrait 3:4 aspect ratio) or 4:3 depending on exact cropping preference. The CSS handles cropping via `aspect-ratio: 4/3` and `object-fit: cover`.
