# Recipe Magazine - Premium WordPress Theme

A premium-quality WordPress recipe blog theme with a warm vintage food magazine aesthetic. Built with pure PHP, HTML5, CSS3, Vanilla JS, and native WordPress features (no external plugins required).

## 1. Theme Installation

1. Download the `recipe-magazine` folder or `.zip` file.
2. In your WordPress admin dashboard, navigate to **Appearance > Themes**.
3. Click **Add New**, then **Upload Theme**.
4. Choose the `.zip` file and click **Install Now**.
5. Once installed, click **Activate**.

## 2. How to customize logo

1. Go to **Appearance > Customize > Site Identity**.
2. Upload your logo using the **Logo** setting (recommended size: 250px by 250px or a horizontal aspect ratio).
3. If no logo is uploaded, the theme will cleanly fallback to displaying the Site Title in the styled `Bebas Neue` font.

## 3. How to create menus

1. Go to **Appearance > Menus**.
2. Create a menu and assign it to **Primary Menu (Categories)**. This displays below the logo/header and is intended for Recipe Categories (e.g., Breakfast, Lunch).
3. Create a second menu and assign it to **Secondary Menu (Pages)**. This displays in the very top dark bar and is intended for static pages (About, Contact, Disclaimer).
4. Create a third menu and assign it to **Footer Menu**.

## 4. How homepage sections work

The homepage automatically populates without needing a page builder:
- **Featured Recipe:** The single main featured recipe is pulled from a post where you checked "Mark as Featured Recipe".
- **Latest Recipes:** Shows a grid of the newest published posts.
- **Popular Now:** Shows recipes sorted by view count. The limit (e.g., top 5) can be changed in **Appearance > Customize > Popular Recipes Settings**.

## 5. How to create recipe posts

1. Go to **Posts > Add New**.
2. Write your post title and add content exactly as you normally would using the Gutenberg editor. This content will become the "Article structure" (Intro, Images, etc.).
3. Add a **Featured Image** in the right sidebar.
4. Assign a **Category**.

## 6. How recipe cards are generated

Below the normal post editor, you will find the **Recipe Data** meta box.
1. Fill out Prep Time, Cook Time, Total Time, Servings, and Calories.
2. Add **Ingredients** using the "Add Ingredient" repeater button.
3. Add **Instructions** using the "Add Instruction" repeater button.
4. If you add Ingredients and Instructions, the beautifully styled Recipe Card and valid JSON-LD schema markup will automatically be generated at the bottom of your post.

## 7. How to use CTA shortcode

Inside the Gutenberg editor, use a Shortcode block and paste the following to create an affiliate CTA box:

```
[recipe_cta label="WHAT WE COOKED WITH" title="The Air Fryer Behind Every Recipe Here" description="Check the model we use for crispy results every time." button="Check Price" url="https://affiliate-link.com"]
```

## 8. How to create affiliate boxes

Use the product box shortcode for a horizontal layout with an image:

```
[product_box image="https://example.com/image.jpg" title="Product Name" description="A brief description of this cool product." button="Buy Now" url="https://affiliate-link.com"]
```

## 9. Customizer options

Go to **Appearance > Customize**:
- **Social Media Links:** Enter URLs for Instagram, Pinterest, Facebook, etc. The icons will automatically appear in the top bar and footer.
- **Popular Recipes Settings:** Define how many popular posts to show on the homepage.

## 10. Widget setup

Go to **Appearance > Widgets**:
- **Sidebar:** Add the "Recipe Magazine: About Author" widget, the "Recipe Magazine: Newsletter" widget, or any native WordPress widget. This sidebar appears on single posts.
- **Footer:** Add widgets here to populate the dark footer area above the copyright line.

## 11. Recommended image sizes

- **Featured Recipe Hero:** 1200x800px (3:2 aspect ratio)
- **Recipe Grid Cards:** 600x800px (Portrait 3:4 aspect ratio) or 4:3 depending on exact cropping preference. The CSS handles cropping via `aspect-ratio: 4/3` and `object-fit: cover` to keep grid uniform regardless of original upload.
- **In-post images:** Maximum width 780px to align perfectly with the centered article content.

## 12. Theme file structure

- `style.css` - Theme header and CSS variables.
- `functions.php` - Theme setup and script enqueuing.
- `front-page.php` - Homepage layout (Featured, Latest, Popular).
- `single.php` - Single post structure.
- `inc/` - Core logic, Customizer, Meta boxes, Shortcodes, Widgets.
- `template-parts/` - Reusable components (`content-single.php`, `content-recipe-card.php`).
- `assets/` - Compiled CSS and JS.

## 13. Troubleshooting

- **Recipe card not showing:** Ensure you have added at least one Ingredient and one Instruction in the Recipe Data box.
- **Schema errors:** Ensure you have filled out the Recipe Name (Post Title) and added a Featured Image.
- **Icons missing:** Check that you have actually entered a URL for the specific social network in the Customizer. Empty fields hide the icon automatically.
