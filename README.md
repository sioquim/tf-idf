# tf-idf
Contains helper function to calculate TF-IDF

# Usage


```sh

$tfIdf = new TfIdf ();

# get tf
$tf = $this->termFrequency($query, $words);

# get idf
$idf = $tfIdf->inverseDocumentFrequency ( $term, $list );

# get tf-idf
$tf = $this->getTFIDF($tf, $idf);
```
