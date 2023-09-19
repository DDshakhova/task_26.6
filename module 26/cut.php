<?php 
 
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

class HtmlIterator implements \Iterator
{
    const ROW_SIZE = 8096;
    protected $filePointer = null;
    protected $currentElement = null;
    protected $rowCounter = null;
    protected $delimiter = null;
 
    public function __construct($file, $delimiter = '<')
    {
        try {
            $this->filePointer = fopen($file, 'rb');
            $this->delimiter = $delimiter;
        } catch (\Exception $e) {
            throw new \Exception('The file "' . $file . '" cannot be read.');
        }
    }
 
    public function rewind(): void
    {
        $this->rowCounter = 0;
        rewind($this->filePointer);
    }
 
    public function current(): mixed
    {
        $this->currentElement = fgetcsv($this->filePointer, self::ROW_SIZE, $this->delimiter);
        $this->rowCounter++;
 
        return $this->currentElement;
    }
 
    public function key(): int
    {
        return $this->rowCounter;
    }
   
     public function next(): void

     {
        next($this -> currentElement);
     }
    
    public function valid(): bool
    {

        {
            if (is_resource($this->filePointer)) {
                return !feof($this->filePointer);
            }
     
            return false;
        }

        if (!$this->next()) {
            if (is_resource($this->filePointer)) {
                fclose($this->filePointer);
            }
 
            return false;
        }
 
        return true;
    }
}
 
$html = new HtmlIterator('html.txt');
 
foreach ($html as $key => $row) {
    if  (strrpos(json_encode($row), 'keywords') != false) {
        echo null;
    }
    elseif (strrpos(json_encode($row), 'description') != false) {
        echo null;
    }

    else {
    foreach($row as $key=>$val) {
        if ($key == 0)
        continue;
        echo htmlspecialchars('<' . $val);
    echo '<br>';}
    }
}

?>