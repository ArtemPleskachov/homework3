<?php
namespace PhpPro\Programa\ValueObject;

class UrlCodePair
{
    //прописуємо змінні для даних які хочемо отримувати
    protected string $code;
    protected string $url;

    /**
     * @param string $code
     * @param string $url
     */
    public function __construct(string $code, string $url) //використовуємо контсруктор для передачі даних в об'єкт
    {
        $this->code = $code;
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }
}


//Даний об'єкт дуже цікавий для нас тим, що він є закритим та приймає данні через конструктор, а також
//має два гетера - через які можемо отримати данні, но не змінювати.
//Така конструкція гарантує, що данні будуть не змінні в незалежності від того де будемо використовувати цей об'єкт
//Як приклад: дані юзера



