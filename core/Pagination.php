<?php


class Pagination
{

    /**
     * Aktif sayfa numarası.
     * @var int
     */
    private $current;

    /**
     * Toplam sayfa sayısı.
     * @var int
     */
    private $total;

    /**
     * Her sayfada bulunacak eleman sayısı
     * @var int
     */
    private $limit;

    /**
     * Aktif sayfaya göre kaçıncı elemandan başlanacağı
     * @var int
     */
    private $offset;

    /**
     * Önceki sayfa
     * @var bool|int
     */
    private $prev;

    /**
     * Sonraki sayfa
     * @var bool|int
     */
    private $next;

    /**
     * Sayfalar
     * @var array
     */
    private $pages;


    /**
     * Pagination constructor.
     *
     * @param int $current Sayfa numarası
     * @param int $total Toplam kayıt sayısı
     * @param int $limit Her sayfada bulunacak eleman sayısı
     */
    public function __construct($current, $total, $limit)
    {
        $this->current = (int) $current;
        $this->total = (int) ceil($total / $limit);
        $this->limit = $limit;

        if ($this->current === 0) {
            $this->current = 1;
        }

        if ($this->current > $total) {
            $this->current = $total;
        }

        $this->offset = $this->total > 1 ? ($this->current - 1) * $this->limit : 0;

        $this->prev = $this->current > 1 ? $this->current - 1 : false;
        $this->next = $this->current < $this->total ? $this->current + 1 : false;
    }


    /**
     * Pagination nesnesini statik olarak oluşturur.
     *
     * @param $current
     * @param $total
     * @param $limit
     * @return Pagination
     */
    public static function make($current, $total, $limit)
    {
        return new self($current, $total, $limit);
    }


    /**
     * Sayfaların hesaplar ve oluşturur.
     */
    public function generate()
    {
        $pages = array();

        $number = 1;
        $index = $this->current - 2;
        $diff = $this->total - $this->current;

        if ($diff < 2) {
            $index = $index - (2 - $diff);
        }

        while (($number <= 5) && ($index <= $this->total)) {
            if ($index >= 1){
                $pages[] = $index;
                $number++;
            }

            $index++;
        }

        $this->pages = $pages;
    }


    /**
     * Önceki sayfayı döndürür.
     *
     * @return bool|int
     */
    public function getPrev()
    {
        return $this->prev;
    }


    /**
     * Sonraki sayfayı döndürür.
     *
     * @return bool|int
     */
    public function getNext()
    {
        return $this->next;
    }


    /**
     * İlk sayfayı döndürür.
     *
     * @return bool|int
     */
    public function getFirst()
    {
        if ($this->prev > 2) {
            return 1;
        }

        return false;
    }


    /**
     * Son sayfayı döndürür.
     *
     * @return bool|int
     */
    public function getLast()
    {
        if ($this->next > 0 && $this->next < ($this->total - 1)) {
            return $this->total;
        }

        return false;
    }


    /**
     * Tüm sayfaları döndürür.
     *
     * @return array
     */
    public function getPages()
    {
        return $this->pages;
    }


    /**
     * Aktif sayfayı döndürür.
     *
     * @return int
     */
    public function getCurrent()
    {
        return $this->current;
    }


    /**
     * Sayfadaki eleman sayısını limitini döndürür.
     *
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }


    /**
     * Aktif sayfaya göre kaçıncı elemandan başlanacağını döndürür.
     *
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }


    /**
     * Sayfa sayısının 1'den fazla olup olmadını kontrol eder.
     *
     * @return bool
     */
    public function moreThanOnePage()
    {
        if ($this->total > 1) {
            return true;
        }

        return false;
    }


}