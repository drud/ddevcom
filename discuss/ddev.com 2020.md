# ddev.com 2020

## Navigation

### Main Navigation

**Products**

Product pages will utilize a new product template. ⚠️

- DDEV Live
- DDEV Local
- DDEV Preview (Coming Soon)

**Resources**

The case studies archive and single views are new templates. ⚠️

- Case Studies ?

**Solutions**

This would require the creation of a new solutions template or post type. ⚠️ ?
 
- Developers ?
- Agency Owners ?
- Product Owners ?
- Open Source Projects ?
- Events/Conferences ?

**Company**

- About ⚠️
- Blog ✅
- Podcast ?
- Contact ✅
- Jobs ✅
- Partners ?

**Shop** ↗️

### Product Navigation

**DDEV Local**

- Get Started ↗️
- Documentation ↗️
- Examples ↗️
- Community ↗️
- Contribute ↗️

**DDEV Live**

- Pricing
- Get Started ↗️
- Documentation ↗️
- Examples ↗️
- Community ↗️

### Footer Navigation

**Products**

- DDEV Live
- DDEV Local
- DDEV Preview (Coming Soon)

**Company**

- About ✅
- Blog ✅
- Podcast ?
- Contact ↗️
- Jobs ✅

**Documentation**

- DDEV Local ↗️
- DDEV Live ↗️

**Subnavigation**

- Terms of Service
- Privacy Policy
- Technical Support Policies

## Implementation

### Content

- Spike to work with Content team to develop strategy
- DDEV Local Product Page Content
- DDEV Live Product Page Content
- DDEV Preview (Coming Soon) Page Content

### Options

#### Option 1: Page Templates with ACF

Quick and dirty implementation. We can even hard-code the content to make it faster, but this is more difficult to edit later. This might be the best solution if we plan to rebuild the site someday.

- Product Page Template `template-product.php` ⚠️
- Pricing Page Template `template-pricing.php` ⚠️
- Solution Page Template `template-solution.php` ⚠️ ?
- About Page Template `template-about.php` ⚠️ ?
- Case Study Archive `archive-case-study.php` ⚠️ ? (Post-launch)
- Case Study Single `single-case-study.php` ⚠️ ? (Post-launch)

#### Option 2: Gutenberg Page Builder Plugin

Nathan has installed Stackable plugin, a block builder for Gutenberg for editing WordPress pages. This might take a little more time, as we would have to "massage" a pre-existing plugin to do exactly what we want. We can expect to build some custom Gutenberg blocks if we need custom functionality. We would need to make sure Marketing is comfortable editing in blocks.

