# phpblm

*Major fun with Rightmove BLM files*

Really old PHP class for parsing out Rightmove BLM files. Will try and clean up a bit at some point. There was also some stuff to process zips and the images that I might be able to knock into some kind of shape.

## Usage

```php
$blm = new phpblm("test.BLM");

// Property count
echo $blm->propCount();

// Get the postcode of the first property
echo $blm->getData("POSTCODE1", 0);

// See everything
print_r($blm->properties());
```

## Licence

If you need such a thing, consider it MIT.