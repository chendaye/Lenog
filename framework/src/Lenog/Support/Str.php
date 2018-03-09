<?php
/**
 * Created by PhpStorm.
 * User: chendaye666
 * Date: 2018/3/6
 * Time: 16:02
 */

namespace Lenog\Support;


use function GuzzleHttp\Psr7\str;
use Lenog\Support\Traits\Macroable;

class Str
{
    use Macroable;

    /**
     * snake 命名法
     *
     * @var array
     */
    protected static $snakeCache = [];

    /**
     * 驼峰命名法
     *
     * @var array
     */
    protected static $camelCache = [];

    /**
     *studly 命名法
     *
     * @var array
     */
    protected static $studlyCache = [];

    /**
     * 返回给定值后面的 剩余的字符串
     *
     * @param $subject
     * @param $search
     * @return mixed
     */
    public static function after($subject, $search)
    {
        return $search === '' ? $subject : array_reverse(explode($search, $subject, 2))[0];
    }

    /**
     * 转化utf-8 到assii 码
     *
     * @param $value
     * @param string $language
     * @return mixed
     */
    public static function ascii($value, $language = 'en')
    {
        $languageSpecific = static::languageSpecificCharsArray($language);

        if(! is_null($languageSpecific)){
            $value = str_replace($languageSpecific[0], $languageSpecific[2], $value);
        }

        foreach (static::charsArray() as $key => $val){
            $value = str_replace($val, $key, $value);
        }

        return str_replace('/[^\x20-\x7E]/u', '', $value);
    }


    /**
     * 获取给定值之前的部分
     *
     * @param $subject
     * @param $search
     * @return mixed
     */
    public static function before($subject, $search)
    {
        return $search === '' ? $subject :explode($search, $subject)[0];
    }

    /**
     * 转化值为驼峰形式
     *
     * @param $value
     * @return mixed|string
     */
    public static function camel($value)
    {
        if(isset(static::$camelCache[$value])){
            return static::$camelCache[$value];
        }

        //lcfirst() 函数把字符串中的首字符转换为小写。
        return static::$camelCache[$value] = lcfirst(static::studly($value));
    }

    /**
     * 检查字符是否包含给定的值
     *
     * @param $haystack
     * @param $needles
     * @return bool
     */
    public static function contains($haystack, $needles)
    {
        foreach ((array) $needles as $needle){
            //mb_strpos — 查找字符串在另一个字符串中首次出现的位置 strpos() 不同的是，数字的值不会被当做字符的顺序值
            if($needle !== '' && mb_strpos($haystack, $needle) !== false) return true;
        }

        return false;
    }

    /**
     * 检查字符串是否有给定的结尾
     *
     * @param $haystack
     * @param $needles
     * @return bool
     */
    public static function endsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if(substr($haystack, -strlen($needle)) === (string)$needle){
                return true;
            }
        }

        return false;
    }

    /**
     * Cap a string with a single instance of a given value.
     *
     * @param $value
     * @param $cap
     * @return string
     */
    public static function finish($value, $cap)
    {
        //preg_quote()函数的作用是转义正则表达式字符
        //在匹配的字符中有正则表达式字符的时候使用，作用是转义正则表达式字符（向正则表达式语法中的字符前增加一个反斜线）
        //（如下的例子中则是将*very*变成\*very\*）,返回转义后的字符串
        $quoted = preg_quote($cap, '/');

        return preg_replace('/(?:'.$quoted.')+$/u', '', $value).$cap;
    }

    /**
     * 检查字符串是否匹配给定的模式
     *
     * @param $pattern
     * @param $value
     * @return bool
     */
    public static function is($pattern, $value)
    {
        $patterns = is_array($pattern) ? $pattern : (array) $pattern;

        if (empty($patterns)) return false;

        foreach ($patterns as $pattern) {
            // If the given value is an exact match we can of course return true right
            // from the beginning. Otherwise, we will translate asterisks and do an
            // actual pattern match against the two strings to see if they match.
            if ($pattern == $value) return true;

            $pattern = preg_quote($pattern, '#');

            // Asterisks are translated into zero-or-more regular expression wildcards
            // to make it convenient to check if the strings starts with the given
            // pattern such as "library/*", making any string check convenient.
            $pattern = str_replace('\*', '.*', $pattern);

            if (preg_match('#^'.$pattern.'\z#u', $value) === 1) {
                return true;
            }
        }

        return false;
    }

    /**
     * 转化字符串 为 kebab形式
     *
     * @param $value
     * @return mixed
     */
    public static function kebab($value)
    {
        return static::snake($value, '-');
    }


    /**
     * 计算字符长度
     *
     * @param $value
     * @param null $encoding
     * @return int
     */
    public static function length($value, $encoding = null)
    {
        if($encoding){
            return mb_strlen($value, $encoding);
        }

        //mb_strlen函数可以较好地解决这个问题。mb_strlen的用法和 strlen类似，只不过它有第二个可选参数用于指定字符编码
        return mb_strlen($value);
    }

    /**
     * 限制字符串的字符数
     *
     * @param $value
     * @param int $limit
     * @param string $end
     * @return string
     */
    public static function limit($value, $limit = 100, $end = '...')
    {
        //mb_strwidth — 返回字符串的宽度
        if(mb_strwidth($value, 'UTF-8') <= $limit){
            return $value;
        }
        //mb_strimwidth — 获取按指定宽度截断的字符串
        return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')).$end;
    }

    /**
     * 转化字符串为小写
     *
     * @param $value
     * @return mixed|string
     */
    public static function lower($value)
    {
        return mb_strtolower($value, 'UTF-8');
    }

    /**
     * 限制字符串里的单词数量
     *
     * @param $value
     * @param int $words
     * @param string $end
     * @return string
     */
    public static function words($value, $words = 100, $end = '...')
    {
        //匹配 字符串
        preg_match('/^\s*+(?:\S++\s*+){1,'.$words.'}/u', $value, $matches);

        //如果没有匹配到 或者匹配到 与给定值的长度一直 直接返回给定值
        if (! isset($matches[0]) || static::length($value) === static::length($matches[0])) {
            return $value;
        }

        //默认返回匹配到的值
        return rtrim($matches[0]).$end;
    }

    /**
     * 解析一个  Class@method 形式的回调函数 到 类或方法里
     * Parse a Class@method style callback into class and method.
     *
     * @param $callback
     * @param null $default
     * @return array
     */
    public static function parseCallback($callback, $default = null)
    {
        return static::contains($callback, '@') ? explode('@', $callback, 2) : [$callback, $default];
    }

    /**
     * 从英文单词里获取复数
     *
     * @param $value
     * @param int $count
     * @return mixed
     */
    public static function plural($value, $count = 2)
    {
        return Pluralizer::plural($value, $count);
    }


    /**
     *生成一个更真实的随机字符串
     *
     * @param int $length
     * @return string
     */
    public static function random($length = 16)
    {
        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;

            //random_bytes - 生成密码安全的伪随机字节
            $bytes = random_bytes($size);

            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }


    /**
     * 连续的用一个数组中的值代替字符串中指定的值
     *
     * @param $search
     * @param array $replace
     * @param $subject
     * @return mixed
     */
    public static function replaceArray($search, array $replace, $subject)
    {
        foreach ($replace as $value){
            $subject = static::replaceFirst($search, $value, $subject);
        }

        return $subject;
    }

    /**
     * 用给定的值 代替字符串中第一个匹配待的内容
     *
     * @param $search
     * @param $replace
     * @param $subject
     * @return mixed
     */
    public static function replaceFirst($search, $replace, $subject)
    {
        if($search == '') return $subject;

        $position = strpos($subject, $search);

        if($position !== false){
            return substr_replace($subject, $replace, $position, strlen($search));
        }

        return $subject;
    }

    /**
     * 用给定的值替换匹配到的最后一个内容
     *
     * @param $search
     * @param $replace
     * @param $subject
     * @return mixed
     */
    public static function replaceLast($search, $replace, $subject)
    {
        $position = strrpos($subject, $search);

        if($position !== false){
            //substr_replace — 替换字符串的子串
            return substr_replace($subject, $replace, $position, strlen($search));
        }

        return $subject;
    }

    /**
     *开始一个字符串用给定值的单个实例
     *
     * @param $value
     * @param $prefix
     * @return string
     */
    public static function start($value, $prefix)
    {
        //preg_quote — 转义正则表达式字符
        $quoted = preg_quote($prefix, '/');

        return $prefix.preg_replace('/^(?:'.$quoted.')+/u', '', $value);
    }

    /**
     * 转换给定的值为大写
     *
     * @param $value
     * @return mixed|string
     */
    public static function upper($value)
    {
        return mb_strtoupper($value, 'UTF-8');
    }

    /**
     * 转换给定值为标题类型
     *
     * @param $value
     * @return mixed|string
     */
    public static function title($value)
    {
        return mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
    }

    /**
     * 获取英文单词的单数
     *
     * @param $value
     * @return mixed
     */
    public static function singular($value)
    {
        return Pluralizer::singular($value);
    }

    /**
     * Generate a URL friendly "slug" from a given string.
     *
     * @param $title
     * @param string $separator
     * @param string $language
     * @return string
     */
    public static function slug($title, $separator = '-', $language = 'en')
    {
        $title = static::ascii($title, $language);
        // Convert all dashes/underscores into separator
        $flip = $separator == '-' ? '_' : '-';

        $title = preg_replace('!['.preg_quote($flip).']+!u', $separator, $title);

        // Replace @ with the word 'at'
        $title = str_replace('@', $separator.'at'.$separator, $title);

        // Remove all characters that are not the separator, letters, numbers, or whitespace.
        $title = preg_replace('![^'.preg_quote($separator).'\pL\pN\s]+!u', '', mb_strtolower($title));

        // Replace all separator characters and whitespace by a single separator
        $title = preg_replace('!['.preg_quote($separator).'\s]+!u', $separator, $title);

        return trim($title, $separator);
    }


    /**
     * Convert a string to snake case.
     *
     * @param $value
     * @param string $delimiter
     * @return mixed|string
     */
    public static function snake($value, $delimiter = '_')
    {
        $key = $value;

        if(isset(static::$snakeCache[$key[$delimiter]])){
            return static::$snakeCache[$key][$delimiter];
        }

        //ctype_lower — 做小写字符检测
        if(! ctype_lower($value)){
            $value = preg_replace('/\s+/u', '', ucwords($value));

            $value = static::lower(preg_replace('/(.)(?=[A-Z])/u', '$1'.$delimiter, $value));
        }

        return static::$snakeCache[$key][$delimiter] = $value;
    }

    /**
     * 检查字符串是否 以给定的值开始
     *
     * @param $haystack
     * @param $needles
     * @return bool
     */
    public static function startsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle){
            if ($needle !== '' && substr($haystack, 0, strlen($needle)) === (string) $needle) {
                return true;
            }
        }

        return false;
    }

    /**
     * Convert a value to studly caps case.
     *
     * @param $value
     * @return mixed
     */
    public static function studly($value)
    {
        $key = $value;

        if(isset(static::$studlyCache[$key])){
            return static::$studlyCache[$key];
        }

        $value = ucwords(str_replace(['-', '_'], ' ', $value));

        return static::$studlyCache[$key] = str_replace(' ', '', $value);
    }

    /**
     * 返回字符串的一部分 通过开始和长度参数
     *
     * @param $string
     * @param $start
     * @param null $length
     * @return string
     */
    public static function substr($string, $start, $length = null)
    {
        return mb_substr($string, $start, $length, 'UTF-8');
    }

    /**
     * 首字母大写
     *
     * @param $string
     * @return string
     */
    public static function ucfirst($string)
    {
        return static::upper(static::substr($string, 0, 1)).static::substr($string, 1);
    }

    /**
     * Returns the replacements for the ascii method.
     *
     * Note: Adapted from Stringy\Stringy.
     *
     * @see https://github.com/danielstjules/Stringy/blob/3.1.0/LICENSE.txt
     *
     * @return array
     */
    protected static function charsArray()
    {
        static $charsArray;

        if (isset($charsArray)) {
            return $charsArray;
        }

        return $charsArray = [
            '0'    => ['°', '₀', '۰', '０'],
            '1'    => ['¹', '₁', '۱', '１'],
            '2'    => ['²', '₂', '۲', '２'],
            '3'    => ['³', '₃', '۳', '３'],
            '4'    => ['⁴', '₄', '۴', '٤', '４'],
            '5'    => ['⁵', '₅', '۵', '٥', '５'],
            '6'    => ['⁶', '₆', '۶', '٦', '６'],
            '7'    => ['⁷', '₇', '۷', '７'],
            '8'    => ['⁸', '₈', '۸', '８'],
            '9'    => ['⁹', '₉', '۹', '９'],
            'a'    => ['à', 'á', 'ả', 'ã', 'ạ', 'ă', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ', 'ā', 'ą', 'å', 'α', 'ά', 'ἀ', 'ἁ', 'ἂ', 'ἃ', 'ἄ', 'ἅ', 'ἆ', 'ἇ', 'ᾀ', 'ᾁ', 'ᾂ', 'ᾃ', 'ᾄ', 'ᾅ', 'ᾆ', 'ᾇ', 'ὰ', 'ά', 'ᾰ', 'ᾱ', 'ᾲ', 'ᾳ', 'ᾴ', 'ᾶ', 'ᾷ', 'а', 'أ', 'အ', 'ာ', 'ါ', 'ǻ', 'ǎ', 'ª', 'ა', 'अ', 'ا', 'ａ', 'ä'],
            'b'    => ['б', 'β', 'ب', 'ဗ', 'ბ', 'ｂ'],
            'c'    => ['ç', 'ć', 'č', 'ĉ', 'ċ', 'ｃ'],
            'd'    => ['ď', 'ð', 'đ', 'ƌ', 'ȡ', 'ɖ', 'ɗ', 'ᵭ', 'ᶁ', 'ᶑ', 'д', 'δ', 'د', 'ض', 'ဍ', 'ဒ', 'დ', 'ｄ'],
            'e'    => ['é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ', 'ë', 'ē', 'ę', 'ě', 'ĕ', 'ė', 'ε', 'έ', 'ἐ', 'ἑ', 'ἒ', 'ἓ', 'ἔ', 'ἕ', 'ὲ', 'έ', 'е', 'ё', 'э', 'є', 'ə', 'ဧ', 'ေ', 'ဲ', 'ე', 'ए', 'إ', 'ئ', 'ｅ'],
            'f'    => ['ф', 'φ', 'ف', 'ƒ', 'ფ', 'ｆ'],
            'g'    => ['ĝ', 'ğ', 'ġ', 'ģ', 'г', 'ґ', 'γ', 'ဂ', 'გ', 'گ', 'ｇ'],
            'h'    => ['ĥ', 'ħ', 'η', 'ή', 'ح', 'ه', 'ဟ', 'ှ', 'ჰ', 'ｈ'],
            'i'    => ['í', 'ì', 'ỉ', 'ĩ', 'ị', 'î', 'ï', 'ī', 'ĭ', 'į', 'ı', 'ι', 'ί', 'ϊ', 'ΐ', 'ἰ', 'ἱ', 'ἲ', 'ἳ', 'ἴ', 'ἵ', 'ἶ', 'ἷ', 'ὶ', 'ί', 'ῐ', 'ῑ', 'ῒ', 'ΐ', 'ῖ', 'ῗ', 'і', 'ї', 'и', 'ဣ', 'ိ', 'ီ', 'ည်', 'ǐ', 'ი', 'इ', 'ی', 'ｉ'],
            'j'    => ['ĵ', 'ј', 'Ј', 'ჯ', 'ج', 'ｊ'],
            'k'    => ['ķ', 'ĸ', 'к', 'κ', 'Ķ', 'ق', 'ك', 'က', 'კ', 'ქ', 'ک', 'ｋ'],
            'l'    => ['ł', 'ľ', 'ĺ', 'ļ', 'ŀ', 'л', 'λ', 'ل', 'လ', 'ლ', 'ｌ'],
            'm'    => ['м', 'μ', 'م', 'မ', 'მ', 'ｍ'],
            'n'    => ['ñ', 'ń', 'ň', 'ņ', 'ŉ', 'ŋ', 'ν', 'н', 'ن', 'န', 'ნ', 'ｎ'],
            'o'    => ['ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ', 'ø', 'ō', 'ő', 'ŏ', 'ο', 'ὀ', 'ὁ', 'ὂ', 'ὃ', 'ὄ', 'ὅ', 'ὸ', 'ό', 'о', 'و', 'θ', 'ို', 'ǒ', 'ǿ', 'º', 'ო', 'ओ', 'ｏ', 'ö'],
            'p'    => ['п', 'π', 'ပ', 'პ', 'پ', 'ｐ'],
            'q'    => ['ყ', 'ｑ'],
            'r'    => ['ŕ', 'ř', 'ŗ', 'р', 'ρ', 'ر', 'რ', 'ｒ'],
            's'    => ['ś', 'š', 'ş', 'с', 'σ', 'ș', 'ς', 'س', 'ص', 'စ', 'ſ', 'ს', 'ｓ'],
            't'    => ['ť', 'ţ', 'т', 'τ', 'ț', 'ت', 'ط', 'ဋ', 'တ', 'ŧ', 'თ', 'ტ', 'ｔ'],
            'u'    => ['ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự', 'û', 'ū', 'ů', 'ű', 'ŭ', 'ų', 'µ', 'у', 'ဉ', 'ု', 'ူ', 'ǔ', 'ǖ', 'ǘ', 'ǚ', 'ǜ', 'უ', 'उ', 'ｕ', 'ў', 'ü'],
            'v'    => ['в', 'ვ', 'ϐ', 'ｖ'],
            'w'    => ['ŵ', 'ω', 'ώ', 'ဝ', 'ွ', 'ｗ'],
            'x'    => ['χ', 'ξ', 'ｘ'],
            'y'    => ['ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ', 'ÿ', 'ŷ', 'й', 'ы', 'υ', 'ϋ', 'ύ', 'ΰ', 'ي', 'ယ', 'ｙ'],
            'z'    => ['ź', 'ž', 'ż', 'з', 'ζ', 'ز', 'ဇ', 'ზ', 'ｚ'],
            'aa'   => ['ع', 'आ', 'آ'],
            'ae'   => ['æ', 'ǽ'],
            'ai'   => ['ऐ'],
            'ch'   => ['ч', 'ჩ', 'ჭ', 'چ'],
            'dj'   => ['ђ', 'đ'],
            'dz'   => ['џ', 'ძ'],
            'ei'   => ['ऍ'],
            'gh'   => ['غ', 'ღ'],
            'ii'   => ['ई'],
            'ij'   => ['ĳ'],
            'kh'   => ['х', 'خ', 'ხ'],
            'lj'   => ['љ'],
            'nj'   => ['њ'],
            'oe'   => ['ö', 'œ', 'ؤ'],
            'oi'   => ['ऑ'],
            'oii'  => ['ऒ'],
            'ps'   => ['ψ'],
            'sh'   => ['ш', 'შ', 'ش'],
            'shch' => ['щ'],
            'ss'   => ['ß'],
            'sx'   => ['ŝ'],
            'th'   => ['þ', 'ϑ', 'ث', 'ذ', 'ظ'],
            'ts'   => ['ц', 'ც', 'წ'],
            'ue'   => ['ü'],
            'uu'   => ['ऊ'],
            'ya'   => ['я'],
            'yu'   => ['ю'],
            'zh'   => ['ж', 'ჟ', 'ژ'],
            '(c)'  => ['©'],
            'A'    => ['Á', 'À', 'Ả', 'Ã', 'Ạ', 'Ă', 'Ắ', 'Ằ', 'Ẳ', 'Ẵ', 'Ặ', 'Â', 'Ấ', 'Ầ', 'Ẩ', 'Ẫ', 'Ậ', 'Å', 'Ā', 'Ą', 'Α', 'Ά', 'Ἀ', 'Ἁ', 'Ἂ', 'Ἃ', 'Ἄ', 'Ἅ', 'Ἆ', 'Ἇ', 'ᾈ', 'ᾉ', 'ᾊ', 'ᾋ', 'ᾌ', 'ᾍ', 'ᾎ', 'ᾏ', 'Ᾰ', 'Ᾱ', 'Ὰ', 'Ά', 'ᾼ', 'А', 'Ǻ', 'Ǎ', 'Ａ', 'Ä'],
            'B'    => ['Б', 'Β', 'ब', 'Ｂ'],
            'C'    => ['Ç', 'Ć', 'Č', 'Ĉ', 'Ċ', 'Ｃ'],
            'D'    => ['Ď', 'Ð', 'Đ', 'Ɖ', 'Ɗ', 'Ƌ', 'ᴅ', 'ᴆ', 'Д', 'Δ', 'Ｄ'],
            'E'    => ['É', 'È', 'Ẻ', 'Ẽ', 'Ẹ', 'Ê', 'Ế', 'Ề', 'Ể', 'Ễ', 'Ệ', 'Ë', 'Ē', 'Ę', 'Ě', 'Ĕ', 'Ė', 'Ε', 'Έ', 'Ἐ', 'Ἑ', 'Ἒ', 'Ἓ', 'Ἔ', 'Ἕ', 'Έ', 'Ὲ', 'Е', 'Ё', 'Э', 'Є', 'Ə', 'Ｅ'],
            'F'    => ['Ф', 'Φ', 'Ｆ'],
            'G'    => ['Ğ', 'Ġ', 'Ģ', 'Г', 'Ґ', 'Γ', 'Ｇ'],
            'H'    => ['Η', 'Ή', 'Ħ', 'Ｈ'],
            'I'    => ['Í', 'Ì', 'Ỉ', 'Ĩ', 'Ị', 'Î', 'Ï', 'Ī', 'Ĭ', 'Į', 'İ', 'Ι', 'Ί', 'Ϊ', 'Ἰ', 'Ἱ', 'Ἳ', 'Ἴ', 'Ἵ', 'Ἶ', 'Ἷ', 'Ῐ', 'Ῑ', 'Ὶ', 'Ί', 'И', 'І', 'Ї', 'Ǐ', 'ϒ', 'Ｉ'],
            'J'    => ['Ｊ'],
            'K'    => ['К', 'Κ', 'Ｋ'],
            'L'    => ['Ĺ', 'Ł', 'Л', 'Λ', 'Ļ', 'Ľ', 'Ŀ', 'ल', 'Ｌ'],
            'M'    => ['М', 'Μ', 'Ｍ'],
            'N'    => ['Ń', 'Ñ', 'Ň', 'Ņ', 'Ŋ', 'Н', 'Ν', 'Ｎ'],
            'O'    => ['Ó', 'Ò', 'Ỏ', 'Õ', 'Ọ', 'Ô', 'Ố', 'Ồ', 'Ổ', 'Ỗ', 'Ộ', 'Ơ', 'Ớ', 'Ờ', 'Ở', 'Ỡ', 'Ợ', 'Ø', 'Ō', 'Ő', 'Ŏ', 'Ο', 'Ό', 'Ὀ', 'Ὁ', 'Ὂ', 'Ὃ', 'Ὄ', 'Ὅ', 'Ὸ', 'Ό', 'О', 'Θ', 'Ө', 'Ǒ', 'Ǿ', 'Ｏ', 'Ö'],
            'P'    => ['П', 'Π', 'Ｐ'],
            'Q'    => ['Ｑ'],
            'R'    => ['Ř', 'Ŕ', 'Р', 'Ρ', 'Ŗ', 'Ｒ'],
            'S'    => ['Ş', 'Ŝ', 'Ș', 'Š', 'Ś', 'С', 'Σ', 'Ｓ'],
            'T'    => ['Ť', 'Ţ', 'Ŧ', 'Ț', 'Т', 'Τ', 'Ｔ'],
            'U'    => ['Ú', 'Ù', 'Ủ', 'Ũ', 'Ụ', 'Ư', 'Ứ', 'Ừ', 'Ử', 'Ữ', 'Ự', 'Û', 'Ū', 'Ů', 'Ű', 'Ŭ', 'Ų', 'У', 'Ǔ', 'Ǖ', 'Ǘ', 'Ǚ', 'Ǜ', 'Ｕ', 'Ў', 'Ü'],
            'V'    => ['В', 'Ｖ'],
            'W'    => ['Ω', 'Ώ', 'Ŵ', 'Ｗ'],
            'X'    => ['Χ', 'Ξ', 'Ｘ'],
            'Y'    => ['Ý', 'Ỳ', 'Ỷ', 'Ỹ', 'Ỵ', 'Ÿ', 'Ῠ', 'Ῡ', 'Ὺ', 'Ύ', 'Ы', 'Й', 'Υ', 'Ϋ', 'Ŷ', 'Ｙ'],
            'Z'    => ['Ź', 'Ž', 'Ż', 'З', 'Ζ', 'Ｚ'],
            'AE'   => ['Æ', 'Ǽ'],
            'Ch'   => ['Ч'],
            'Dj'   => ['Ђ'],
            'Dz'   => ['Џ'],
            'Gx'   => ['Ĝ'],
            'Hx'   => ['Ĥ'],
            'Ij'   => ['Ĳ'],
            'Jx'   => ['Ĵ'],
            'Kh'   => ['Х'],
            'Lj'   => ['Љ'],
            'Nj'   => ['Њ'],
            'Oe'   => ['Œ'],
            'Ps'   => ['Ψ'],
            'Sh'   => ['Ш'],
            'Shch' => ['Щ'],
            'Ss'   => ['ẞ'],
            'Th'   => ['Þ'],
            'Ts'   => ['Ц'],
            'Ya'   => ['Я'],
            'Yu'   => ['Ю'],
            'Zh'   => ['Ж'],
            ' '    => ["\xC2\xA0", "\xE2\x80\x80", "\xE2\x80\x81", "\xE2\x80\x82", "\xE2\x80\x83", "\xE2\x80\x84", "\xE2\x80\x85", "\xE2\x80\x86", "\xE2\x80\x87", "\xE2\x80\x88", "\xE2\x80\x89", "\xE2\x80\x8A", "\xE2\x80\xAF", "\xE2\x81\x9F", "\xE3\x80\x80", "\xEF\xBE\xA0"],
        ];
    }

    /**
     * Returns the language specific replacements for the ascii method.
     *
     * Note: Adapted from Stringy\Stringy.
     *
     * @see https://github.com/danielstjules/Stringy/blob/3.1.0/LICENSE.txt
     *
     * @param  string  $language
     * @return array|null
     */
    protected static function languageSpecificCharsArray($language)
    {
        static $languageSpecific;

        if (! isset($languageSpecific)) {
            $languageSpecific = [
                'bg' => [
                    ['х', 'Х', 'щ', 'Щ', 'ъ', 'Ъ', 'ь', 'Ь'],
                    ['h', 'H', 'sht', 'SHT', 'a', 'А', 'y', 'Y'],
                ],
                'de' => [
                    ['ä',  'ö',  'ü',  'Ä',  'Ö',  'Ü'],
                    ['ae', 'oe', 'ue', 'AE', 'OE', 'UE'],
                ],
            ];
        }

        return $languageSpecific[$language] ?? null;
    }


}