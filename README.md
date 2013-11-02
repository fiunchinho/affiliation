#Affiliation Localizer
## Motivation
If you've signed up in some affiliation program, like Amazon UK, you'll have to write Amazon links in your blog posts and banners. But if your visitor comes from France instead of UK, it'd be awesome to use affiliation links from Amazon France because that visitor will most likely buy from there.
With this library, instead of writing the Amazon links directly in your page, you'll use links of your own domain that will redirect to the proper Amazon link, **based on the country of the user**.

Also, if you wanted to change your affiliation partner from Amazon to another provider, instead of reviewing every article on your blog and changing the links, **you just need to update the configuration file**.

The library supports defaults to be used when the country or the product is not in your configuration file.

## Configuration
You just need to create a YAML file with the *mappings* between the products that you want to use and the link in the affiliation page. Since we are using the country of the user to decide which page to link to, the configuration file will look something like this:

    ES:
        product1: www.example.com/product1-es
        product2: www.example.com/product2-es
    FR:
        product1: www.example.com/product1-fr
        product2: www.anotherexample.com/product2-fr
    DE:
        product1: www.anothersite.com/product1-de
        product2: www.example.com/product2-de
    PT:
        ES

As you can see in the last entry, you could one country to *inherit* from another one. This way, the mapping for a user coming from PT (Portugal) is the same than a user coming from ES (Spain).