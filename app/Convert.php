<?php
/**
 * @author Rokas Rudgalvis PRIf-16/2
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Convert extends Model
{
    public $input;
    public $input_type;
    public $org_input;
    public $org_input_type;
    public $output_type;
    public $output;
    //Skaitmenys prieš kablelį
    public $n;
    //Skaitmenys po kablelį
    public $_n;
    //Šešioliktainės sistemos simboliai
    public $symbols = [
        0 =>  0,
        1  => 1,
        2  => 2,
        3  => 3,
        4  => 4,
        5  => 5,
        6  => 6,
        7  => 7,
        8  => 8,
        9  => 9,
        10 => 'A',
        11 => 'B',
        12 => 'C',
        13 => 'D',
        14 => 'E',
        15 => 'F',
    ];

    /**
     * @param mixed[] $data Duomenys iš POST
     * @return void Užpildo public kintamuosius
     */
    public function load($data)
    {
        $this->input = $data['input'];
        $this->org_input = $data['input'];
        $this->input_type = $data['type'];
        $this->org_input_type = $data['type'];
        $this->output_type = $data['r_type'];

        /**
         * Jeigu skaiius nėra sveikas
         * ir jeigu reikia keistį į dešimtainę skaič. sistemą
         * įvest skaičių išskaido į dalį prieš kablelį ir po kablelio
        */
        $str = strpos($this->input, ',');

        if($str !== false && $this->output_type == 10){
            $parts = explode(',', $this->input);
            $this->n = strlen($parts[0]);
            $this->_n = strlen($parts[1]);
            $new = str_replace(',', '', $this->input);
            $this->input = $new;
        }else{
            $this->n = strlen($this->input);
            $this->_n = 0;
        }
    }

    /**
     * @return void Įrašo galutinį rezultatą į public $output
     */
    public function convert()
    {
        if($this->output_type == 10)
            $result = $this->convertTo10();
        elseif($this->output_type == 2)
            $result = $this->fix2($result = $this->repopulateAs10());
        else
            $result = $this->repopulateAs10();

        $this->output = $result;
    }


    /**
     * Duotajį skaičių konvertuoja į dešimtainę skaičiavimo sistema, o tada į norimą s. sistemą
     * @return int
     */
    public function repopulateAs10()
    {
        //Pradinę įvestį konvertuoją į dešimtainę sistemą
        $this->input = $this->convertTo10();
        $this->input_type = 10;

        $result = $this->devide();

        $this->input = $this->org_input;
        $this->input_type = $this->org_input_type;

        return $result;

    }

    /**
     * Pritaiko formulę N = a(n-1) * q^(n-1) + a(n-2) * q^(n-2) + ... + a(-m) * q^(-m);
     * @return int
     */
    public function convertTo10()
    {
        //Pateikiamasis skaičius
        $N = 0;

        for($i = 0; $i < strlen($this->input); $i++){
            //Skaičiavimo sistemos pagrindas
            $q = (int)$this->input_type;
            //Laipsnis, kuriuo keliamas $q
            $pow = (int)$this->n - 1 - $i;
            //Skaitmuo su kuriuo atliekami veiksmai
            if(!is_numeric($this->input[$i]))
                $a = array_search($this->input[$i], $this->symbols, true);
            else
                $a = (int)$this->input[$i];

            $N += $a * pow($q, $pow);
        }

        return $N;
    }


    /**
     * Dalinimo metodu išskaido skaičių ir surenką naująjį
     * @return int
     */
    public function devide()
    {
        return $this->construct($this->breakdown());
    }

    /**
     * @param int|string
     *
     * Pataiso dvejetainį skaičių į lengvai skaitomą skaičių, t.y.
     * užpildo nuliais tol kol skaičiaus simbolių skaičius bus 4-ių kartotinis;
     * įterpia tarpo simbolius kas ketvirtą simbolį
     *
     * @return string
     */
    public function fix2($N)
    {
        $correct =  4 * ceil(strlen($N) / 4);

        //Skaičiaus priekyje prideda nulių tiek, kad susidarydų 4-ių kartotinio ilgio skaičius
        $N = str_pad($N, $correct, 0, STR_PAD_LEFT);
        //Įterpia tarpo simbolį kas keturis skaičius
        $N = chunk_split($N, 4, ' ');

        return $N;
    }

    /**
     * Iš paskutinio dalmens ir liekanų surenka skaičių;
     * Skaičiams nuo 10 iki 15 priskiria raidines reikšmes
     * @return int
     */
    public function construct($extract)
    {
        $N = '';
        for($i = count($extract)-1; $i >= 0; $i--){
            if($extract[count($extract)-1]['d'] > 0 && $i == count($extract)-1)
                $N = $this->symbols[$extract[$i]['d']];

            $N .= $this->symbols[$extract[$i]['l']];
        }

        return $N;
    }

    /**
     * Dalina duotajį skaičių iš norimo skaičiavimo sistemos pagrindo;
     * į masyvą surašo dalmenį ir liekaną.
     *
     * @return array[
     *  ['d' => int, 'l' => int]
     * ]
     * d - dalmuo
     * l - liekana
     */
    public function breakdown()
    {
        $rez = [];

        $dalinys = $this->input;
        $daliklis = $this->output_type;

        while(true){
            $dalmuo = floor($dalinys / $daliklis);
            $liekana = $dalinys % $daliklis;

            $rez[] = [
                'd' => $dalmuo,
                'l' => $liekana
            ];

            $dalinys = $dalmuo;

            if($dalmuo < $daliklis)
                break;
        }

        return $rez;

    }
}
