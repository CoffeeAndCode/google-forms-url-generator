# Google Forms URL Generator

> Generate URLs for Google Forms that are prepopulated and ready to submit.

## Getting Started

The file `src/URLGenerator.php` includes all of the logic needed to build a
prefilled and submittable Google Form urls. Feel free to pull it into your
project however works best for you.


### Generating URLs

The codebase is very lightweight and does not attempt to pull your form details
from Google's APIs. That means you'll need to figure out the form field IDs
on your own by:

1. Create a Google Form with all of the fields (and options) that you'll need.
1. Create a pre-filled URL filling in each of the questions.

You'll end up with a long url that looks similar to this:

```
https://docs.google.com/a/google-apps-account.com/forms/d/xxxxxxxxxxxxxxxxx-xxxxxxx-xxxxx_xxxxxxxxxxxx/viewform?entry.11111=Option+1&entry.22222=This+is+a+short+answer.&entry.33333=This+is+a+longer+answer.%0A%0AIt+can+have+multiple+lines.&entry.44444=Option+2&entry.55555=5&entry.66666=Column+1&entry.77777=Column+2&entry.88888=Column+3&entry.99999=2016-01-03&entry.101010=22:23
```

You can then start to associate the form field IDs (like `11111`, `22222`, and `33333` above) to the fields that you created in your Google Form. Once you
have your field IDs, you can generate a pre-filled URL or submittable URL.


### Pre-filled URLs

Pre-filled URLs will take the user to the Google Form where they can continue
to made edits and then finally submit on their own when they are ready.

```php
// This is the url from the prefilled form example above. Make sure it ends
// after the form ID and does not have a trailing slash.
$formURL = 'https://docs.google.com/a/google-apps-account.com/forms/d/xxxxxxxxxxxxxxxxx-xxxxxxx-xxxxx_xxxxxxxxxxxx';

// This creates the url generator instance we can utilize.
$generator = new GoogleFormsURLGenerator\URLGenerator($formURL);

// Create a prefilled url for your Google Form passing an associative array
// of field IDs and the values they are assigned.
$prefilledURL = $generator->prefilledURL(array(
    '11111' => 'My answer for this question.',
    '22222' => ['Multiple choice response', 'the other response']
));

// https://docs.google.com/a/google-apps-account.com/forms/d/xxxxxxxxxxxxxxxxx-xxxxxxx-xxxxx_xxxxxxxxxxxx/viewform?entry.11111=My+answer+for+this+question.&entry.22222=Multiple+choice+response&entry.22222=the+other+response
```


### Submittable URLs

Submittable urls will not only prefil the values, but will also submit the form
well and take the user to the submission response page. You generate them by
passing params in the same format:

```php
// This is the url from the prefilled form example above. Make sure it ends
// after the form ID and does not have a trailing slash.
$formURL = 'https://docs.google.com/a/google-apps-account.com/forms/d/xxxxxxxxxxxxxxxxx-xxxxxxx-xxxxx_xxxxxxxxxxxx';

// This creates the url generator instance we can utilize.
$generator = new GoogleFormsURLGenerator\URLGenerator($formURL);

// Create a prefilled url for your Google Form passing an associative array
// of field IDs and the values they are assigned.
$prefilledURL = $generator->submissionURL(array(
    '11111' => 'My answer for this question.',
    '22222' => ['Multiple choice response', 'the other response']
));

// https://docs.google.com/a/google-apps-account.com/forms/d/xxxxxxxxxxxxxxxxx-xxxxxxx-xxxxx_xxxxxxxxxxxx/formResponse?ifq&entry.11111=My+answer+for+this+question.&entry.22222=Multiple+choice+response&entry.22222=the+other+response&submit=Submit
```


### Limitations

#### Date / Time Data

This library does not handle date or time transformations and will pass the data
as is. You should convert all dates and times to strings in the following
formats:

```php
// year-month-date
$dateValue = '2016-01-25';

// Notice the hour is in 24 hour clock time (aka: military time).
$timeValue = '13:45';
```

#### "Other" Responses

This library also does not handle "Other" responses to multiple choice or
checkbox questions. They require additional query parameters in the generated
urls and I have not built in a way to handle them yet.

An example pre-filled url with an "other" response looks like this:

```
https://docs.google.com/a/google-apps-account.com/forms/d/xxxxxxxxxxxxxxxxx-xxxxxxx-xxxxx_xxxxxxxxxxxx/viewform?entry.11111=Option+1&entry.11111=__other_option__&entry.11111.other_option_response=Other+option+for+a+checkbox
```

In the above example, the option "Option 1" and an "Other" option of "Other option for a checkbox" are prefilled.


## Running the Tests

This project uses Composer to handle dependencies for the project. Once you
have Composer installed, you can run `composer install` to bring in the
project's dependencies which are only used for testing.

You can run the tests for the application with `vendor/bin/phpunit tests/`.

If you'd like to watch the project files and rerun the tests when files are
changed, you can install [Watchman](https://facebook.github.io/watchman/),
then run:

```bash
watchman-make -p 'src/**/*.php' 'tests/**/*.php' --make=vendor/bin/phpunit -t tests
```

## CI Server

This project used to run on CodeShip with the following config and was not migrated to anything else:

### Setup

```
# Set php version through phpenv. 5.3, 5.4, 5.5 & 5.6 available
phpenv local 5.6
# Install extensions through Pecl
# yes yes | pecl install memcache
# Install dependencies through Composer
composer install --prefer-source --no-interaction
```

### Test Pipelines

```
vendor/bin/phpunit tests/
```
