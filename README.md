Textformatter Audio Embed ProcessWire module
--------------------------------------------

Once enabled, this textformatter looks for audio file URLs and converts those to HTML5 `<audio>` elements. Works best with RTE (CKEditor) inputs.

Note that URLs need to be the only content within a paragraph tag. You can use an absolute URL or a relative URL, but in the case of relative URLs the path must point to an audio file within `/site/assets/files/`:

```HTML
<!-- valid -->
<p>https://www.domain.tld/path/to/file.mp3</p>
<p>/site/assets/files/1/file.mp3</p>

<!-- invalid -->
<p>Dude, where's my https://www.domain.tld/path/to/car.mp3</p>
<p>/some/other/path/file.mp3</p>
```

Supported audio file formats:

* .mp3 (audio/mpeg)
* .ogg (audio/ogg)
* .wav (audio/wav)
