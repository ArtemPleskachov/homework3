<?php
namespace PhpPro\Programa;

use PhpPro\Programa\Exceptions\DataNotFoundException;
use PhpPro\Programa\Interfaces\ICodeRepository;
use PhpPro\Programa\ValueObject\UrlCodePair;


class FileRepository implements ICodeRepository
{
    protected string $fileDb;    // тут так розумію файл для зберігання масиву
    protected array $db = [];   // тут прописую масив для збереження даних

    /**
     * @param string $fileDb
     */
    public function __construct(string $fileDb)
    {
        $this->fileDb = $fileDb;
        $this->getDbFromStorage();
    }
    //За допомогою getDbFromStorage ми передаємо декодовані дані з json в зміну $fileDb
    //і також робимо перевірку, якщо файл існує то достаємо з нього дані
    protected function getDbFromStorage()
    {
        if (file_exists($this->fileDb)) {
            $content = file_get_contents($this->fileDb);
            $this->db = (array)json_decode($content, true);
        }
    }

    public function saveEntity(UrlCodePair|Interfaces\UrlCodePair $urlCodePair): bool
    {
        $this->db[$urlCodePair->getCode()] = $urlCodePair->getUrl(); //Масив с ключом Code дорівнює Url
        return true;
    }


    public function codeIsset(string $code): bool
    {
        return isset($this->db[$code]); //перевірити чи є ключ масиву дб.
    }

    public function getUrlByCode(string $code): string
    {
        if (!$this->codeIsset($code)) {
            throw new DataNotFoundException(); // якщо немає ключа в масиві дб, зафайрити екцепшн
        }
        return $this->db[$code];
    }

    public function getCodeByUrl(string $url): string
    {
        if (!$code = array_search($url, $this->db)) {
            throw new DataNotFoundException();
        }
        return $code;
    }

    protected function writeFile(string $content): void
    {
        $file = fopen($this->fileDb, 'w+');
        fwrite($file, $content);
        fclose($file);
    }

    public function __destruct()
    {
        $this->writeFile(json_encode($this->db));
    }
}