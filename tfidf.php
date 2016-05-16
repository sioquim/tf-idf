<?php

class TfIdf
{   
    /**
     * Returns TF value to determine the number of times $term occurs in $words
     * @param  string $term  
     * @param  string $words
     * @return float
     */
    public function getTermFrequency($term, $words)
    {
        $wordCount = count($words);
        $frequency = count(array_keys($words, $term));
        if (!$frequency) return 0;        
        $tf = floatval($frequency) / floatval($wordCount);
        return round($tf, 6);
    }

    /**
     * Returns IDF value to determine how common is the term across all $documents
     * @param  string $term      
     * @param  array $documents 
     * @return float
     */
    public function getInverseDocumentFrequency($term, $documents)
    {
        $docCount     = count($documents);
        $docWithTerms = 0;        
        foreach ($documents as $document) {
            $words = array_filter(explode(',', $document));
            if (in_array($term, $words)) $docWithTerms++;
        }
        if (!($docWithTerms)) return 0;        
        $idf = 1 + log($docCount / $docWithTerms);        
        return $idf;
    }

    /**
     * Returns TF-IDF value to determine how important a $query is to the entire document 
     * @param  string $query 
     * @param  string $words 
     * @param  float  $idf   
     * @return float        
     */
    public function getTFIDF($query, $words, $idf)
    {
        $tf = $this->termFrequency($query, $words);
        return $tf * $idf;
    }

    /**
     * Returns Cosine Similarity value using TF-IDF and IDF values
     * @param  float $idf   
     * @param  float $tfidf
     * @return float
     */
    public function getCosineSimilarity($idf, $tfidf)
    {
        $tf = 1 / count($idf);
        $dotProduct = 0;
        $query  = 0;
        $document  = 0;
        foreach ($tfidf as $key => $value) {
            $dotProduct += (($tf * $idf[$key]) * $value);            
            $query += pow(($tf * $idf[$key]), 2);
            $document += pow($value, 2);
        }        
        $query = sqrt($query);
        $document = sqrt($document);        
        if (!($query * $document)) return 0;         
        return $dotProduct / ($query * $document);
    }

    /**
     * Returns the normalized value of the $data
     * @param  array $data 
     * @return array       
     */
    public function getNormalizeData($data)
    {
        $minX = floatval(min($data));
        $maxX = floatval(max($data));
        foreach ($data as $key => $value) {
            $x = floatval($value);
            $data[$key] = ($x - $minX) / ($maxX - $minX);
            if (!($maxX - $minX)) $data[$key] = 0;
        }
        return $data;
    }   
}
