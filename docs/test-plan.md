# Testing Plan

- [ ] Verify that the testing plan located at docs/test-plan.md of the repository is up to date and accurate.
- [ ] Release plan is documented
- [ ] Verify that code is tagged with appropriate version
- [ ] Verify that all tests pass on all supported browsers and devices

## Main Navigation

[Staging](https://preview-ddev-staging-ddev-external-sites.sites.ddev.live/) | [Production](https://ddev.com/)

- [ ] Click **DDEV Logo** and confirm it navigates to the home page
- [ ] Click **Products -> DDEV-Live** and confirm it navigates to the DDEV-Live product page
- [ ] Click **Products -> DDEV-Local**  and confirm it navigates to the DDEV-Local product page
- [ ] Click **Developers -> Documentation -> DDEV-Local Docs** and confirm it navigates to the [DDEV-Local documentation](https://ddev.readthedocs.io/en/stable) in a new tab
- [ ] Click **Developers -> Documentation -> DDEV-Live Docs** and confirm it navigates to the [DDEV-Live documentation ](https://docs.ddev.com) in a new tab
- [ ] Click **Developers -> Documentation -> GitHub** and confirm it navigates to the [Drud GitHub](https://github.com/drud) in a new tab
- [ ] Click **Developers -> Documentation -> Jobs** and confirm it navigates to the Jobs page
- [ ] Click **Events** and confirm it navigates to the Events page. 
- [ ] Click **Blog** and confirm it navigates to the Blog page
- [ ] Click **Contact** and confirm it navigates to the Contact page

## Front Page

[Staging](https://preview-ddev-staging-ddev-external-sites.sites.ddev.live/) | [Production](https://ddev.com/)

- [ ] Click **Deploy to our cloud** button and confirm it navigates to the DDEV-Live product page
- [ ] Click **Develop locally** button and confirm it navigates to the DDEV-Local product page
- [ ] Confirm the Recent Posts section is displaying the most recent six posts.
- [ ] Click the **Join Newsletter** button and confirm it navigates to our Mailchimp newsletter signup form.  [Should open in new tab, issue here](https://github.com/drud/ddevcom/issues/151)
## DDEV-Live Page

[Staging](https://preview-ddev-staging-ddev-external-sites.sites.ddev.live/ddev-live) | [Production](https://ddev.com/ddev-live)

### Navigation

- [ ] Click **Start a free trial** and confirm it navigates to the DDEV-Live dashboard registration page.  [Should open in a new tab, issue here](https://github.com/drud/ddevcom/issues/153)
- [ ] Click **Pricing** and confirm it navigates to the DDEV-Live dashboard pricing page.  [Should open in a new tab, issue here](https://github.com/drud/ddevcom/issues/154)
- [ ] Click **Developers -> Documentation** and confirm it navigates to the DDEV-Live documentation in a new tab
- [ ] Click **Developers -> Get Started** and confirm it navigates to the Get Started section of the DDEV-Live documentation in a new tab

### Main Hero

- [ ] Click **Start a free trial** button and confirm it navigates to the DDEV-Live dashboard registration page.  [Should open in a new tab, see issue 153](https://github.com/drud/ddevcom/issues/153)
- [ ] Click **Documentation** button and confirm it navigates to the DDEV-Live documentation in a new tab.

### Features

- [ ] Click **Git Integration -> Git repository provider** link and confirm it navigates to the DDEV-Live Providers documentation in a new tab
- [ ] Click **Continuous Integration -> CI/CD** link and confirm it navigates to the DDEV-Live CI/CD page
- [ ] Click **Tutorial: DDEV-LIve + Jenkins** button and confirm it navigates to the DDEV-Live Jenkins tutorial documentation.  [Should open in a new tab, issue here](https://github.com/drud/ddevcom/issues/155)
- [ ] Click the next **Start a free trial** button and confirm it navigates to the DDEV-Live dashboard registration page.  [Should open in a new tab, see issue 153](https://github.com/drud/ddevcom/issues/153)
- [ ] Click the next **Request Demo** button and confirm it navigates to the Contact page
- [ ] Click the final **Start a free trial** button and confirm it navigates to the DDEV-Live dashboard registration page. [ Should open in a new tab, see issue 153](https://github.com/drud/ddevcom/issues/153)
- [ ] Click the final **Request Demo** button and confirm it navigates to the Contact page

### Recent Posts

- [ ] Verify the **Recent Posts** section only displays the most recent posts with DDEV Live category.  [Missing a Recent Post header, posts are for DDEV Local not Live](https://github.com/drud/ddevcom/issues/156)
- [ ] Check the blog cards using the **Blog Posts** checklist below
- [ ] Verify the **Join Newsletter** button links to our Mailchimp form in a new tab

## DDEV-Local Page

[Staging](https://preview-ddev-staging-ddev-external-sites.sites.ddev.live/ddev-local) | [Production](https://ddev.com/ddev-local)

### Navigation

- [ ] Click **Get Started** and confirm it navigates to the Get Started page
- [ ] Click **Documentation** and confirm it navigates to the DDEV-Local documentation in a new tab
- [ ] Click **Quickstart Guides -> PHP** and confirm it navigates to the DDEV-Local documentation quickstart guide for PHP in a new tab
- [ ] Click **Quickstart Guides -> WordPress** and confirm it navigates to the DDEV-Local documentation quickstart guide for WordPress in a new tab
- [ ] Click **Quickstart Guides -> Drupal 8** and confirm it navigates to the DDEV-Local documentation quickstart guide for Drupal 8 in a new tab
- [ ] Click **Quickstart Guides -> Drupal 9** and confirm it navigates to the DDEV-Local documentation quickstart guide for Drupal 9 in a new tab
- [ ] Click **Quickstart Guides -> Drupal 6 & 7** and confirm it navigates to the DDEV-Local documentation quickstart guide for Drupal 6 & 7 in a new tab
- [ ] Click **Quickstart Guides -> TYPO3** and confirm it navigates to the DDEV-Local documentation quickstart guide for TYPO3 in a new tab
- [ ] Click **Quickstart Guides -> Backdrop** and confirm it navigates to the DDEV-Local documentation quickstart guide for Backdrop in a new tab
- [ ] Click **Quickstart Guides -> Magento 1** and confirm it navigates to the DDEV-Local documentation quickstart guide for Magento 1 in a new tab
- [ ] Click **Quickstart Guides -> Magento 2** and confirm it navigates to the DDEV-Local documentation quickstart guide for Magento 2 in a new tab
- [ ] Click **GitHub** and confirm it navigates to the DDEV-Local GitHub page in a new tab
- [ ] Click **Get Started** and confirm it navigates to the Get Started page
- [ ] Click **Documentation** and confirm it navigates to the Documentation in a new tab

### Features

- [ ] Click **Get Started** and confirm it navigates to the Get Started page
- [ ] Click **Documentation** and confirm it navigates to the Documentation in a new tab
- [ ] Click the next **Get Started** and confirm it navigates to the Get Started page
- [ ] Click the next **Documentation** and confirm it navigates to the Documentation in a new tab

### Recent Posts

- [ ] Verify the **Recent Posts** section only displays the most recent posts with DDEV Local category.  Blocked by #157 
- [ ] Check the blog cards using the **Blog Posts** checklist below
- [ ] Verify the **Join Newsletter** button links to our Mailchimp form in a new tab

### Connect

## Blog Posts

- [ ] Click a blog card's image and confirm it goes to that blog post
- [ ] Click a blog card's title and confirm it goes to that blog post
- [ ] Click a blog card's author and confirm it goes to that author's post archive. Blocked by #158
