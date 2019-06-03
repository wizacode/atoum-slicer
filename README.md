Slice your [Atoum](http://docs.atoum.org/fr/latest/) test suite in chunks to run it in parallel.


## Usage

Install atoum-slicer using Composer:

```
composer require --dev wizaplace/atoum-slicer
```

Instead of running your test suite with `vendor/bin/atoum`, run atoum-slicer instead:

```
vendor/bin/atoum-slicer --slices 1/2
```

The `--slices` allows to define how many slices to use and which one to run. For example `1/2` means that the test suite will be split in 2, and only the first slice will be run.

Atoum-slicer is mainly useful for continuous integration: it allows to run a large test suite in parallel accross several jobs. To enable this, simply replace your single Atoum job with 2 (or more) jobs:

- `vendor/bin/atoum-slicer --slices 1/2`
- `vendor/bin/atoum-slicer --slices 2/2`

## License

This project is released under [the MIT license](LICENSE).
