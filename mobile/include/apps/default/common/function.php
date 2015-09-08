<?php



/* 访问控制 */

defined('IN_ECTOUCH') or die('Deny Access');



/**

 * 检查是否是微信浏览器访问

 */

function is_wechat_browser()

{

    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    if (strpos($user_agent, 'MicroMessenger') === false) {

        return false;

    } else {

        return true;

    }

}



/**

 * 取得页面标题

 *

 * @access  public

 * @return  string

 */

function get_page_title($cat = 0, $str = '') {

    /* 初始化“页面标题”和“当前位置” */

    $page_title = C('shop_title');

    $ur_here = '<a href="' . __APP__ . '">' . L('home') . '</a>';

    /* 控制器名称 */

    $controller_name = strtolower(CONTROLLER_NAME);

    /* 处理有分类的 */

    if (in_array($controller_name, array('category', 'goods', 'article', 'brand'))) {

        /* 商品分类或商品 */

        if ('category' == $controller_name || 'goods' == $controller_name || 'brand' == $controller_name) {

            if ($cat > 0) {

                $cat_arr = model('Category')->get_parent_cats($cat);

                $key = 'cid';

                $type = 'category/index';

            } else {

                $cat_arr = array();

            }

        } elseif ('article' == $controller_name) { /* 文章分类或文章 */

            if ($cat > 0) {

                $cat_arr = model('Article')->get_article_parent_cats($cat);

                $key = 'acid';

                $type = 'article/index';

            } else {

                $cat_arr = array();

            }

        }

        /* 循环分类 */

        if (!empty($cat_arr)) {

            krsort($cat_arr);

            foreach ($cat_arr AS $val) {

                $page_title = htmlspecialchars($val['cat_name']) . '_' . $page_title;

                $args = array($key => $val['cat_id']);

                $ur_here .= ' <code>&gt;</code> <a href="' . url($type, $args) . '">' . htmlspecialchars($val['cat_name']) . '</a>';

            }

        }

    } else { /* 处理无分类的 */

        /* 团购 */

        if ('groupbuy' == $controller_name) {

            $page_title = L('group_buy_goods') . '_' . $page_title;

            $args = array('gbid' => '0');

            $ur_here .= ' <code>&gt;</code> <a href="' . url('groupbuy/index', $args) . '">' . L('group_buy_goods') . '</a>';

        }

        /* 拍卖 */ elseif ('auction' == $controller_name) {

            $page_title = L('auction') . '_' . $page_title;

            $args = array('auid' => '0');

            $ur_here .= ' <code>&gt;</code> <a href="' . url('auction/index', $args) . '">' . L('auction') . '</a>';

        }

        /* 夺宝 */ elseif ('snatch' == $controller_name) {

            $page_title = L('snatch') . '_' . $page_title;

            $args = array('id' => '0');

            $ur_here .= ' <code> &gt; </code><a href="' . url('snatch/index', $args) . '">' . L('snatch') . '</a>';

        }

        /* 批发 */ elseif ('wholesale' == $controller_name) {

            $page_title = L('wholesale') . '_' . $page_title;

            $args = array('wsid' => '0');

            $ur_here .= ' <code>&gt;</code> <a href="' . url('wholesale/index', $args) . '">' . L('wholesale') . '</a>';

        }

        /* 积分兑换 */ elseif ('exchange' == $controller_name) {

            $page_title = L('exchange') . '_' . $page_title;

            $args = array('wsid' => '0');

            $ur_here .= ' <code>&gt;</code> <a href="' . url('exchange/index', $args) . '">' . L('exchange') . '</a>';

        }

        /* 其他的在这里补充 */

    }



    /* 处理最后一部分 */

    if (!empty($str)) {

        $page_title = $str . '_' . $page_title;

        $ur_here .= ' <code>&gt;</code> ' . $str;

    }



    /* 返回值 */

    return array('title' => $page_title, 'ur_here' => $ur_here);

}



/**

 * 根据提供的数组编译成页面标题

 *

 * @access  public

 * @param   string  $type   类型

 * @param   array   $arr    分类数组

 * @return  string

 */

function build_pagetitle($arr, $type = 'category') {

    $str = '';



    foreach ($arr AS $val) {

        $str .= htmlspecialchars($val['cat_name']) . '_';

    }



    return $str;

}



/**

 * 根据提供的数组编译成当前位置

 *

 * @access  public

 * @param   string  $type   类型

 * @param   array   $arr    分类数组

 * @return  void

 */

function build_urhere($arr, $type = 'category') {

    krsort($arr);



    $str = '';

    foreach ($arr AS $val) {

        switch ($type) {

            case 'category':

            case 'brand':

                $args = array('cid' => $val['cat_id']);

                break;

            case 'article_cat':

                $args = array('acid' => $val['cat_id']);

                break;

        }



        $str .= ' <code>&gt;</code> <a href="' . url($type, $args) . '">' . htmlspecialchars($val['cat_name']) . '</a>';

    }



    return $str;

}



/**

 * 创建分页信息

 *

 * @access  public

 * @param   string  $app            程序名称，如category

 * @param   string  $cat            分类ID

 * @param   string  $record_count   记录总数

 * @param   string  $size           每页记录数

 * @param   string  $sort           排序类型

 * @param   string  $order          排序顺序

 * @param   string  $page           当前页

 * @param   string  $keywords       查询关键字

 * @param   string  $brand          品牌

 * @param   string  $price_min      最小价格

 * @param   string  $price_max      最高价格

 * @return  void

 */

function assign_pager($app, $cat, $record_count, $size, $sort, $order, $page = 1, $keywords = '', $brand = 0, $price_min = 0, $price_max = 0, $display_type = 'list', $filter_attr = '', $url_format = '', $sch_array = '') {

    $sch = array('keywords' => $keywords,

        'sort' => $sort,

        'order' => $order,

        'cat' => $cat,

        'brand' => $brand,

        'price_min' => $price_min,

        'price_max' => $price_max,

        'filter_attr' => $filter_attr,

        'display' => $display_type

    );



    $page = intval($page);

    if ($page < 1) {

        $page = 1;

    }



    $page_count = $record_count > 0 ? intval(ceil($record_count / $size)) : 1;



    $pager['page'] = $page;

    $pager['size'] = $size;

    $pager['sort'] = $sort;

    $pager['order'] = $order;

    $pager['record_count'] = $record_count;

    $pager['page_count'] = $page_count;

    $pager['display'] = $display_type;



    /* 分页样式 */

    $page_style = C('page_style');

    $pager['styleid'] = isset($page_style) ? intval($page_style) : 0;



    $page_prev = ($page > 1) ? $page - 1 : 1;

    $page_next = ($page < $page_count) ? $page + 1 : $page_count;



    switch ($app) {

        case 'category/index':

            $uri_args = array('id' => $cat, 'bid' => $brand, 'price_min' => $price_min, 'price_max' => $price_max, 'filter_attr' => $filter_attr, 'sort' => $sort, 'order' => $order, 'display' => $display_type, 'keywords' => $keywords);

            break;

        case 'article_cat':

            $uri_args = array('acid' => $cat, 'sort' => $sort, 'order' => $order);

            break;

        case 'brand':

            $uri_args = array('cid' => $cat, 'bid' => $brand, 'sort' => $sort, 'order' => $order, 'display' => $display_type);

            break;

        case 'search':

            $uri_args = array('cid' => $cat, 'bid' => $brand, 'sort' => $sort, 'order' => $order);

            break;

        case 'exchange':

            $uri_args = array('cid' => $cat, 'integral_min' => $price_min, 'integral_max' => $price_max, 'sort' => $sort, 'order' => $order, 'display' => $display_type);

            break;

    }

    if ($pager['styleid'] == 0) {

        if (!empty($url_format)) {

            $pager['page_first'] = $url_format . 1;

            $pager['page_prev'] = $url_format . $page_prev;

            $pager['page_next'] = $url_format . $page_next;

            $pager['page_last'] = $url_format . $page_count;

        } else {

            $pager['page_first'] = url($app, array_merge($uri_args, array('page' => 1)));

            $pager['page_prev'] = url($app, array_merge($uri_args, array('page' => $page_prev)));

            $pager['page_next'] = url($app, array_merge($uri_args, array('page' => $page_next)));

            $pager['page_last'] = url($app, array_merge($uri_args, array('page' => $page_count)));

        }

        $pager['array'] = array();



        for ($i = 1; $i <= $page_count; $i++) {

            $pager['array'][$i] = $i;

        }

    } else {

        $_pagenum = 10;     // 显示的页码

        $_offset = 2;       // 当前页偏移值

        $_from = $_to = 0;  // 开始页, 结束页

        if ($_pagenum > $page_count) {

            $_from = 1;

            $_to = $page_count;

        } else {

            $_from = $page - $_offset;

            $_to = $_from + $_pagenum - 1;

            if ($_from < 1) {

                $_to = $page + 1 - $_from;

                $_from = 1;

                if ($_to - $_from < $_pagenum) {

                    $_to = $_pagenum;

                }

            } elseif ($_to > $page_count) {

                $_from = $page_count - $_pagenum + 1;

                $_to = $page_count;

            }

        }

        if (!empty($url_format)) {

            $pager['page_first'] = ($page - $_offset > 1 && $_pagenum < $page_count) ? $url_format . 1 : '';

            $pager['page_prev'] = ($page > 1) ? $url_format . $page_prev : '';

            $pager['page_next'] = ($page < $page_count) ? $url_format . $page_next : '';

            $pager['page_last'] = ($_to < $page_count) ? $url_format . $page_count : '';

            $pager['page_kbd'] = ($_pagenum < $page_count) ? true : false;

            $pager['page_number'] = array();

            for ($i = $_from; $i <= $_to; ++$i) {

                $pager['page_number'][$i] = $url_format . $i;

            }

        } else {

            $pager['page_first'] = ($page - $_offset > 1 && $_pagenum < $page_count) ? url($app, array_merge($uri_args, array('page' => 1))) : '';

            $pager['page_prev'] = ($page > 1) ? url($app, array_merge($uri_args, array('page' => $page_prev))) : '';

            $pager['page_next'] = ($page < $page_count) ? url($app, array_merge($uri_args, array('page' => $page_next))) : '';

            $pager['page_last'] = ($_to < $page_count) ? url($app, array_merge($uri_args, array('page' => $page_count))) : '';

            $pager['page_kbd'] = ($_pagenum < $page_count) ? true : false;

            $pager['page_number'] = array();

            for ($i = $_from; $i <= $_to; ++$i) {

                $pager['page_number'][$i] = url($app, array_merge($uri_args, array('page' => $i)));

            }

        }

    }

    if (!empty($sch_array)) {

        $pager['search'] = $sch_array;

    } else {

        $pager['search']['category'] = $cat;

        foreach ($sch AS $key => $row) {

            $pager['search'][$key] = $row;

        }

    }



    ECTouch::view()->assign('pager', $pager);

}



/**

 *  生成给pager.lbi赋值的数组

 *

 * @access  public

 * @param   string      $url        分页的链接地址(必须是带有参数的地址，若不是可以伪造一个无用参数)

 * @param   array       $param      链接参数 key为参数名，value为参数值

 * @param   int         $record     记录总数量

 * @param   int         $page       当前页数

 * @param   int         $size       每页大小

 *

 * @return  array       $pager

 */

function get_pager($url, $param, $record_count, $page = 1, $size = 10) {

    $size = intval($size);

    if ($size < 1) {

        $size = 10;

    }



    $page = intval($page);

    if ($page < 1) {

        $page = 1;

    }



    $record_count = intval($record_count);



    $page_count = $record_count > 0 ? intval(ceil($record_count / $size)) : 1;

    if ($page > $page_count) {

        $page = $page_count;

    }

    /* 分页样式 */

    $page_style = C('page_style');

    $pager['styleid'] = isset($page_style) ? intval($page_style) : 0;



    $page_prev = ($page > 1) ? $page - 1 : 1;

    $page_next = ($page < $page_count) ? $page + 1 : $page_count;



    /* 将参数合成url字串 */

    $param_url = '?';

    foreach ($param AS $key => $value) {

        $param_url .= $key . '=' . $value . '&';

    }



    $pager['url'] = $url;

    $pager['start'] = ($page - 1) * $size;

    $pager['page'] = $page;

    $pager['size'] = $size;

    $pager['record_count'] = $record_count;

    $pager['page_count'] = $page_count;



    if ($pager['styleid'] == 0) {

        $pager['page_first'] = $url . $param_url . 'page=1';

        $pager['page_prev'] = $url . $param_url . 'page=' . $page_prev;

        $pager['page_next'] = $url . $param_url . 'page=' . $page_next;

        $pager['page_last'] = $url . $param_url . 'page=' . $page_count;

        $pager['array'] = array();

        for ($i = 1; $i <= $page_count; $i++) {

            $pager['array'][$i] = $i;

        }

    } else {

        $_pagenum = 10;     // 显示的页码

        $_offset = 2;       // 当前页偏移值

        $_from = $_to = 0;  // 开始页, 结束页

        if ($_pagenum > $page_count) {

            $_from = 1;

            $_to = $page_count;

        } else {

            $_from = $page - $_offset;

            $_to = $_from + $_pagenum - 1;

            if ($_from < 1) {

                $_to = $page + 1 - $_from;

                $_from = 1;

                if ($_to - $_from < $_pagenum) {

                    $_to = $_pagenum;

                }

            } elseif ($_to > $page_count) {

                $_from = $page_count - $_pagenum + 1;

                $_to = $page_count;

            }

        }

        $url_format = $url . $param_url . 'page=';

        $pager['page_first'] = ($page - $_offset > 1 && $_pagenum < $page_count) ? $url_format . 1 : '';

        $pager['page_prev'] = ($page > 1) ? $url_format . $page_prev : '';

        $pager['page_next'] = ($page < $page_count) ? $url_format . $page_next : '';

        $pager['page_last'] = ($_to < $page_count) ? $url_format . $page_count : '';

        $pager['page_kbd'] = ($_pagenum < $page_count) ? true : false;

        $pager['page_number'] = array();

        for ($i = $_from; $i <= $_to; ++$i) {

            $pager['page_number'][$i] = $url_format . $i;

        }

    }

    $pager['search'] = $param;



    return $pager;

}



/**

 * 调用调查内容

 *

 * @access  public

 * @param   integer $id   调查的编号

 * @return  array

 */

function get_vote($id = '') {

    /* 随机取得一个调查的主题 */

    if (empty($id)) {

        $time = gmtime();

        $sql = 'SELECT vote_id, vote_name, can_multi, vote_count, RAND() AS rnd' .

                ' FROM ' . M()->pre .

                "vote WHERE start_time <= '$time' AND end_time >= '$time' " .

                ' ORDER BY rnd LIMIT 1';

    } else {

        $sql = 'SELECT vote_id, vote_name, can_multi, vote_count' .

                ' FROM ' . M()->pre .

                "vote WHERE vote_id = '$id'";

    }

    $res = M()->query($sql);

    $vote_arr = $res[0];



    if ($vote_arr !== false && !empty($vote_arr)) {

        /* 通过调查的ID,查询调查选项 */

        $sql_option = 'SELECT v.*, o.option_id, o.vote_id, o.option_name, o.option_count ' .

                'FROM ' . M()->pre . 'vote AS v, ' .

                M()->pre . 'vote_option AS o ' .

                "WHERE o.vote_id = v.vote_id AND o.vote_id = '$vote_arr[vote_id]' ORDER BY o.option_order ASC, o.option_id DESC";

        $res = M()->query($sql_option);



        /* 总票数 */

        $sql = 'SELECT SUM(option_count) AS all_option FROM ' . M()->pre .

                "vote_option WHERE vote_id = '" . $vote_arr['vote_id'] . "' GROUP BY vote_id";

        $all_option = M()->query($sql);

        $option_num = $all_option[0]['all_option'];



        $arr = array();

        $count = 100;

        foreach ($res AS $idx => $row) {

            if ($option_num > 0 && $idx == count($res) - 1) {

                $percent = $count;

            } else {

                $percent = ($row['vote_count'] > 0 && $option_num > 0) ? round(($row['option_count'] / $option_num) * 100) : 0;



                $count -= $percent;

            }

            $arr[$row['vote_id']]['options'][$row['option_id']]['percent'] = $percent;



            $arr[$row['vote_id']]['vote_id'] = $row['vote_id'];

            $arr[$row['vote_id']]['vote_name'] = $row['vote_name'];

            $arr[$row['vote_id']]['can_multi'] = $row['can_multi'];

            $arr[$row['vote_id']]['vote_count'] = $row['vote_count'];



            $arr[$row['vote_id']]['options'][$row['option_id']]['option_id'] = $row['option_id'];

            $arr[$row['vote_id']]['options'][$row['option_id']]['option_name'] = $row['option_name'];

            $arr[$row['vote_id']]['options'][$row['option_id']]['option_count'] = $row['option_count'];

        }



        $vote_arr['vote_id'] = (!empty($vote_arr['vote_id'])) ? $vote_arr['vote_id'] : '';



        $vote = array('id' => $vote_arr['vote_id'], 'content' => $arr);



        return $vote;

    }

}



/**

 * 获得浏览器名称和版本

 *

 * @access  public

 * @return  string

 */

function get_user_browser() {

    if (empty($_SERVER['HTTP_USER_AGENT'])) {

        return '';

    }



    $agent = $_SERVER['HTTP_USER_AGENT'];

    $browser = '';

    $browser_ver = '';



    if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs)) {

        $browser = 'Internet Explorer';

        $browser_ver = $regs[1];

    } elseif (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs)) {

        $browser = 'FireFox';

        $browser_ver = $regs[1];

    } elseif (preg_match('/Maxthon/i', $agent, $regs)) {

        $browser = '(Internet Explorer ' . $browser_ver . ') Maxthon';

        $browser_ver = '';

    } elseif (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs)) {

        $browser = 'Opera';

        $browser_ver = $regs[1];

    } elseif (preg_match('/OmniWeb\/(v*)([^\s|;]+)/i', $agent, $regs)) {

        $browser = 'OmniWeb';

        $browser_ver = $regs[2];

    } elseif (preg_match('/Netscape([\d]*)\/([^\s]+)/i', $agent, $regs)) {

        $browser = 'Netscape';

        $browser_ver = $regs[2];

    } elseif (preg_match('/safari\/([^\s]+)/i', $agent, $regs)) {

        $browser = 'Safari';

        $browser_ver = $regs[1];

    } elseif (preg_match('/NetCaptor\s([^\s|;]+)/i', $agent, $regs)) {

        $browser = '(Internet Explorer ' . $browser_ver . ') NetCaptor';

        $browser_ver = $regs[1];

    } elseif (preg_match('/Lynx\/([^\s]+)/i', $agent, $regs)) {

        $browser = 'Lynx';

        $browser_ver = $regs[1];

    }



    if (!empty($browser)) {

        return addslashes($browser . ' ' . $browser_ver);

    } else {

        return 'Unknow browser';

    }

}



/**

 * 判断是否为搜索引擎蜘蛛

 *

 * @access  public

 * @return  string

 */

function is_spider($record = true) {

    static $spider = NULL;



    if ($spider !== NULL) {

        return $spider;

    }



    if (empty($_SERVER['HTTP_USER_AGENT'])) {

        $spider = '';



        return '';

    }



    $searchengine_bot = array(

        'googlebot',

        'mediapartners-google',

        'baiduspider+',

        'msnbot',

        'yodaobot',

        'yahoo! slurp;',

        'yahoo! slurp china;',

        'iaskspider',

        'sogou web spider',

        'sogou push spider'

    );



    $searchengine_name = array(

        'GOOGLE',

        'GOOGLE ADSENSE',

        'BAIDU',

        'MSN',

        'YODAO',

        'YAHOO',

        'Yahoo China',

        'IASK',

        'SOGOU',

        'SOGOU'

    );



    $spider = strtolower($_SERVER['HTTP_USER_AGENT']);



    foreach ($searchengine_bot AS $key => $value) {

        if (strpos($spider, $value) !== false) {

            $spider = $searchengine_name[$key];



            if ($record === true) {

                M()->autoReplace(M()->pre . 'searchengine', array('date' => local_date('Y-m-d'), 'searchengine' => $spider, 'count' => 1), array('count' => 1));

            }



            return $spider;

        }

    }



    $spider = '';



    return '';

}



/**

 * 获得客户端的操作系统

 *

 * @access  private

 * @return  void

 */

function get_os() {

    if (empty($_SERVER['HTTP_USER_AGENT'])) {

        return 'Unknown';

    }



    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);

    $os = '';



    if (strpos($agent, 'win') !== false) {

        if (strpos($agent, 'nt 5.1') !== false) {

            $os = 'Windows XP';

        } elseif (strpos($agent, 'nt 5.2') !== false) {

            $os = 'Windows 2003';

        } elseif (strpos($agent, 'nt 5.0') !== false) {

            $os = 'Windows 2000';

        } elseif (strpos($agent, 'nt 6.0') !== false) {

            $os = 'Windows Vista';

        } elseif (strpos($agent, 'nt') !== false) {

            $os = 'Windows NT';

        } elseif (strpos($agent, 'win 9x') !== false && strpos($agent, '4.90') !== false) {

            $os = 'Windows ME';

        } elseif (strpos($agent, '98') !== false) {

            $os = 'Windows 98';

        } elseif (strpos($agent, '95') !== false) {

            $os = 'Windows 95';

        } elseif (strpos($agent, '32') !== false) {

            $os = 'Windows 32';

        } elseif (strpos($agent, 'ce') !== false) {

            $os = 'Windows CE';

        }

    } elseif (strpos($agent, 'linux') !== false) {

        $os = 'Linux';

    } elseif (strpos($agent, 'unix') !== false) {

        $os = 'Unix';

    } elseif (strpos($agent, 'sun') !== false && strpos($agent, 'os') !== false) {

        $os = 'SunOS';

    } elseif (strpos($agent, 'ibm') !== false && strpos($agent, 'os') !== false) {

        $os = 'IBM OS/2';

    } elseif (strpos($agent, 'mac') !== false && strpos($agent, 'pc') !== false) {

        $os = 'Macintosh';

    } elseif (strpos($agent, 'powerpc') !== false) {

        $os = 'PowerPC';

    } elseif (strpos($agent, 'aix') !== false) {

        $os = 'AIX';

    } elseif (strpos($agent, 'hpux') !== false) {

        $os = 'HPUX';

    } elseif (strpos($agent, 'netbsd') !== false) {

        $os = 'NetBSD';

    } elseif (strpos($agent, 'bsd') !== false) {

        $os = 'BSD';

    } elseif (strpos($agent, 'osf1') !== false) {

        $os = 'OSF1';

    } elseif (strpos($agent, 'irix') !== false) {

        $os = 'IRIX';

    } elseif (strpos($agent, 'freebsd') !== false) {

        $os = 'FreeBSD';

    } elseif (strpos($agent, 'teleport') !== false) {

        $os = 'teleport';

    } elseif (strpos($agent, 'flashget') !== false) {

        $os = 'flashget';

    } elseif (strpos($agent, 'webzip') !== false) {

        $os = 'webzip';

    } elseif (strpos($agent, 'offline') !== false) {

        $os = 'offline';

    } else {

        $os = 'Unknown';

    }



    return $os;

}



/**

 * 保存搜索引擎关键字

 *

 * @access  public

 * @return  void

 */

function save_searchengine_keyword($domain, $path) {

    if (strpos($domain, 'google.com.tw') !== false && preg_match('/q=([^&]*)/i', $path, $regs)) {

        $searchengine = 'GOOGLE TAIWAN';

        $keywords = urldecode($regs[1]); // google taiwan

    }

    if (strpos($domain, 'google.cn') !== false && preg_match('/q=([^&]*)/i', $path, $regs)) {

        $searchengine = 'GOOGLE CHINA';

        $keywords = urldecode($regs[1]); // google china

    }

    if (strpos($domain, 'google.com') !== false && preg_match('/q=([^&]*)/i', $path, $regs)) {

        $searchengine = 'GOOGLE';

        $keywords = urldecode($regs[1]); // google

    } elseif (strpos($domain, 'baidu.') !== false && preg_match('/wd=([^&]*)/i', $path, $regs)) {

        $searchengine = 'BAIDU';

        $keywords = urldecode($regs[1]); // baidu

    } elseif (strpos($domain, 'baidu.') !== false && preg_match('/word=([^&]*)/i', $path, $regs)) {

        $searchengine = 'BAIDU';

        $keywords = urldecode($regs[1]); // baidu

    } elseif (strpos($domain, '114.vnet.cn') !== false && preg_match('/kw=([^&]*)/i', $path, $regs)) {

        $searchengine = 'CT114';

        $keywords = urldecode($regs[1]); // ct114

    } elseif (strpos($domain, 'iask.com') !== false && preg_match('/k=([^&]*)/i', $path, $regs)) {

        $searchengine = 'IASK';

        $keywords = urldecode($regs[1]); // iask

    } elseif (strpos($domain, 'soso.com') !== false && preg_match('/w=([^&]*)/i', $path, $regs)) {

        $searchengine = 'SOSO';

        $keywords = urldecode($regs[1]); // soso

    } elseif (strpos($domain, 'sogou.com') !== false && preg_match('/query=([^&]*)/i', $path, $regs)) {

        $searchengine = 'SOGOU';

        $keywords = urldecode($regs[1]); // sogou

    } elseif (strpos($domain, 'so.163.com') !== false && preg_match('/q=([^&]*)/i', $path, $regs)) {

        $searchengine = 'NETEASE';

        $keywords = urldecode($regs[1]); // netease

    } elseif (strpos($domain, 'yodao.com') !== false && preg_match('/q=([^&]*)/i', $path, $regs)) {

        $searchengine = 'YODAO';

        $keywords = urldecode($regs[1]); // yodao

    } elseif (strpos($domain, 'zhongsou.com') !== false && preg_match('/word=([^&]*)/i', $path, $regs)) {

        $searchengine = 'ZHONGSOU';

        $keywords = urldecode($regs[1]); // zhongsou

    } elseif (strpos($domain, 'search.tom.com') !== false && preg_match('/w=([^&]*)/i', $path, $regs)) {

        $searchengine = 'TOM';

        $keywords = urldecode($regs[1]); // tom

    } elseif (strpos($domain, 'live.com') !== false && preg_match('/q=([^&]*)/i', $path, $regs)) {

        $searchengine = 'MSLIVE';

        $keywords = urldecode($regs[1]); // MSLIVE

    } elseif (strpos($domain, 'tw.search.yahoo.com') !== false && preg_match('/p=([^&]*)/i', $path, $regs)) {

        $searchengine = 'YAHOO TAIWAN';

        $keywords = urldecode($regs[1]); // yahoo taiwan

    } elseif (strpos($domain, 'cn.yahoo.') !== false && preg_match('/p=([^&]*)/i', $path, $regs)) {

        $searchengine = 'YAHOO CHINA';

        $keywords = urldecode($regs[1]); // yahoo china

    } elseif (strpos($domain, 'yahoo.') !== false && preg_match('/p=([^&]*)/i', $path, $regs)) {

        $searchengine = 'YAHOO';

        $keywords = urldecode($regs[1]); // yahoo

    } elseif (strpos($domain, 'msn.com.tw') !== false && preg_match('/q=([^&]*)/i', $path, $regs)) {

        $searchengine = 'MSN TAIWAN';

        $keywords = urldecode($regs[1]); // msn taiwan

    } elseif (strpos($domain, 'msn.com.cn') !== false && preg_match('/q=([^&]*)/i', $path, $regs)) {

        $searchengine = 'MSN CHINA';

        $keywords = urldecode($regs[1]); // msn china

    } elseif (strpos($domain, 'msn.com') !== false && preg_match('/q=([^&]*)/i', $path, $regs)) {

        $searchengine = 'MSN';

        $keywords = urldecode($regs[1]); // msn

    }



    if (!empty($keywords)) {

        $gb_search = array('YAHOO CHINA', 'TOM', 'ZHONGSOU', 'NETEASE', 'SOGOU', 'SOSO', 'IASK', 'CT114', 'BAIDU');

        if (EC_CHARSET == 'utf-8' && in_array($searchengine, $gb_search)) {

            $keywords = ecs_iconv('GBK', 'UTF8', $keywords);

        }

        if (EC_CHARSET == 'gbk' && !in_array($searchengine, $gb_search)) {

            $keywords = ecs_iconv('UTF8', 'GBK', $keywords);

        }



        M()->autoReplace(M()->pre . 'keywords', array('date' => local_date('Y-m-d'), 'searchengine' => $searchengine, 'keyword' => addslashes($keywords), 'count' => 1), array('count' => 1));

    }

}



/**

 * 替换动态模块

 *

 * @access  public

 * @param   string       $matches    匹配内容

 *

 * @return string        结果

 */

function dyna_libs_replace($matches) {

    $key = '/' . $matches[1];



    if ($row = array_shift($GLOBALS['libs'][$key])) {

        $str = '';

        switch ($row['type']) {

            case 1:

                // 分类的商品

                $str = '{assign var="cat_goods" value=$cat_goods_' . $row['id'] . '}{assign var="goods_cat" value=$goods_cat_' . $row['id'] . '}';

                break;

            case 2:

                // 品牌的商品

                $str = '{assign var="brand_goods" value=$brand_goods_' . $row['id'] . '}{assign var="goods_brand" value=$goods_brand_' . $row['id'] . '}';

                break;

            case 3:

                // 文章列表

                $str = '{assign var="articles" value=$articles_' . $row['id'] . '}{assign var="articles_cat" value=$articles_cat_' . $row['id'] . '}';

                break;

            case 4:

                //广告位

                $str = '{assign var="ads_id" value=' . $row['id'] . '}{assign var="ads_num" value=' . $row['number'] . '}';

                break;

        }

        return $str . $matches[0];

    } else {

        return $matches[0];

    }

}



/**

 * 处理上传文件，并返回上传图片名(上传失败时返回图片名为空）

 *

 * @access  public

 * @param array     $upload     $_FILES 数组

 * @param array     $type       图片所属类别，即data目录下的文件夹名

 *

 * @return string               上传图片名

 */

function upload_file($upload, $type) {

    if (!empty($upload['tmp_name'])) {

        $ftype = check_file_type($upload['tmp_name'], $upload['name'], '|png|jpg|jpeg|gif|doc|xls|txt|zip|ppt|pdf|rar|docx|xlsx|pptx|');

        if (!empty($ftype)) {

            $name = date('Ymd');

            for ($i = 0; $i < 6; $i++) {

                $name .= chr(mt_rand(97, 122));

            }



            $name = $_SESSION['user_id'] . '_' . $name . '.' . $ftype;



            $target = ROOT_PATH . DATA_DIR . '/' . $type . '/' . $name;

            if (!move_upload_file($upload['tmp_name'], $target)) {

                ECTouch::err()->add(L('upload_file_error'), 1);



                return false;

            } else {

                return $name;

            }

        } else {

            ECTouch::err()->add(L('upload_file_type'), 1);



            return false;

        }

    } else {

        ECTouch::err()->add(L('upload_file_error'));

        return false;

    }

}



/**

 * 显示一个提示信息

 *

 * @access  public

 * @param   string  $content

 * @param   string  $link

 * @param   string  $href

 * @param   string  $type               信息类型：warning, error, info

 * @param   string  $auto_redirect      是否自动跳转

 * @return  void

 */

function show_message($content, $links = '', $hrefs = '', $type = 'info', $auto_redirect = true) {

    assign_template();



    $msg['content'] = $content;

    if (is_array($links) && is_array($hrefs)) {

        if (!empty($links) && count($links) == count($hrefs)) {

            foreach ($links as $key => $val) {

                $msg['url_info'][$val] = $hrefs[$key];

            }

            $msg['back_url'] = $hrefs['0'];

        }

    } else {

        $link = empty($links) ? L('back_up_page') : $links;

        $href = empty($hrefs) ? 'javascript:history.back()' : $hrefs;

        $msg['url_info'][$link] = $href;

        $msg['back_url'] = $href;

    }



    $msg['type'] = $type;

    if (is_null(ECTouch::view()->get_template_vars('helps'))) {

        ECTouch::view()->assign('helps', model('Article')->get_shop_help()); // 网店帮助

    }



    ECTouch::view()->assign('title', L('tips_message'));

    ECTouch::view()->assign('auto_redirect', $auto_redirect);

    ECTouch::view()->assign('message', $msg);

    ECTouch::view()->display('message.dwt');



    exit;

}



/**

 * 将一个形如+10, 10, -10, 10%的字串转换为相应数字，并返回操作符号

 *

 * @access  public

 * @param   string      str     要格式化的数据

 * @param   char        operate 操作符号，只能返回‘+’或‘*’;

 * @return  float       value   浮点数

 */

function parse_rate_value($str, &$operate) {

    $operate = '+';

    $is_rate = false;



    $str = trim($str);

    if (empty($str)) {

        return 0;

    }

    if ($str[strlen($str) - 1] == '%') {

        $value = floatval($str);

        if ($value > 0) {

            $operate = '*';



            return $value / 100;

        } else {

            return 0;

        }

    } else {

        return floatval($str);

    }

}



function assign_template($ctype = '', $catlist = array()) {

    ECTouch::view()->assign('image_width', C('image_width'));

    ECTouch::view()->assign('image_height', C('image_height'));

    ECTouch::view()->assign('points_name', C('integral_name'));

    ECTouch::view()->assign('qq', explode(',', C('qq')));

    ECTouch::view()->assign('ww', explode(',', C('ww')));

    ECTouch::view()->assign('ym', explode(',', C('ym')));

    ECTouch::view()->assign('msn', explode(',', C('msn')));

    ECTouch::view()->assign('skype', explode(',', C('skype')));

    ECTouch::view()->assign('stats_code', C('stats_code'));

    ECTouch::view()->assign('copyright', sprintf(L('copyright'), date('Y'), C('shop_name')));

    ECTouch::view()->assign('shop_name', C('shop_name'));

    ECTouch::view()->assign('service_email', C('service_email'));

    ECTouch::view()->assign('service_phone', C('service_phone'));

    ECTouch::view()->assign('shop_address', C('shop_address'));

    ECTouch::view()->assign('licensed', license_info());

    ECTouch::view()->assign('ecs_version', VERSION);

    ECTouch::view()->assign('icp_number', C('icp_number'));

    ECTouch::view()->assign('username', !empty($_SESSION['user_name']) ? $_SESSION['user_name'] : '');

    ECTouch::view()->assign('category_list', cat_list(0, 0, true, 2, false));

    ECTouch::view()->assign('catalog_list', cat_list(0, 0, false, 1, false));

    ECTouch::view()->assign('navigator_list', model('Common')->get_navigator($ctype, $catlist));  //自定义导航栏



    $search_keywords = C('search_keywords');

    if (!empty($search_keywords)) {

        $searchkeywords = explode(',', trim(C('search_keywords')));

    } else {

        $searchkeywords = array();

    }

    ECTouch::view()->assign('searchkeywords', $searchkeywords);

}



/**

 * 将一个本地时间戳转成GMT时间戳

 *

 * @access  public

 * @param   int     $time

 *

 * @return int      $gmt_time;

 */

function time2gmt($time) {

    return strtotime(gmdate('Y-m-d H:i:s', $time));

}



/**

 * 保存推荐uid

 *

 * @access  public

 * @param   void

 *

 * @return void

 * @author xuanyan

 * */

function set_affiliate($u = '') {

    $_GET['u'] = empty($u) ? $_GET['u'] : $u;

    $config = unserialize(C('affiliate'));

    if (!empty($_GET['u']) && $config['on'] == 1) {

        if (!empty($config['config']['expire'])) {

            if ($config['config']['expire_unit'] == 'hour') {

                $c = 1;

            } elseif ($config['config']['expire_unit'] == 'day') {

                $c = 24;

            } elseif ($config['config']['expire_unit'] == 'week') {

                $c = 24 * 7;

            } else {

                $c = 1;

            }

            setcookie('ecshop_affiliate_uid', intval($_GET['u']), gmtime() + 3600 * $config['config']['expire'] * $c);

        } else {

            setcookie('ecshop_affiliate_uid', intval($_GET['u']), gmtime() + 3600 * 24); // 过期时间为 1 天

        }

    }

}



/**

 * 授权信息内容

 *

 * @return  str

 */

function license_info() {

    if (C('licensed') > 0) {

        $license = '<a href="http://www.ecshop.com/license.php?product=ectouch_free&url=' . urlencode(__URL__) . '" target="_blank"

>&nbsp;&nbsp;Licensed</a>';

        return $license;

    } else {

        return '';

    }

}



/* * ********************************************************

 * 动态内容函数库

 * ******************************************************** */



//调用购物车商品数量 by carson add



function insert_goods_cart_count() {

    return '0';

}



/* * ********************************************************

 * 购物流程函数库

 * ******************************************************** */



/**

 * 处理序列化的支付、配送的配置参数

 * 返回一个以name为索引的数组

 *

 * @access  public

 * @param   string       $cfg

 * @return  void

 */

function unserialize_config($cfg) {

    if (is_string($cfg) && ($arr = unserialize($cfg)) !== false) {

        $config = array();



        foreach ($arr AS $key => $val) {

            $config[$val['name']] = $val['value'];

        }



        return $config;

    } else {

        return false;

    }

}



/**

 * 计算运费

 * @param   string  $shipping_code      配送方式代码

 * @param   mix     $shipping_config    配送方式配置信息

 * @param   float   $goods_weight       商品重量

 * @param   float   $goods_amount       商品金额

 * @param   float   $goods_number       商品数量

 * @return  float   运费

 */

function shipping_fee($shipping_code, $shipping_config, $goods_weight, $goods_amount, $goods_number = '') {

    if (!is_array($shipping_config)) {

        $shipping_config = unserialize($shipping_config);

    }



    $filename = ROOT_PATH . 'plugins/shipping/' . $shipping_code . '.php';

    if (file_exists($filename)) {

        include_once($filename);



        $obj = new $shipping_code($shipping_config);



        return $obj->calculate($goods_weight, $goods_amount, $goods_number);

    } else {

        return 0;

    }

}



/**

 * 获取指定配送的保价费用
 *
 * @access  public
 * @param   string      $shipping_code  配送方式的code
 * @param   float       $goods_amount   保价金额
 * @param   mix         $insure         保价比例
 * @return  float
 */
function shipping_insure_fee($shipping_code, $goods_amount, $insure) {
    if (strpos($insure, '%') === false) {
        /* 如果保价费用不是百分比则直接返回该数值 */
        return floatval($insure);
    } else {
        $path = ROOT_PATH . 'includes/modules/shipping/' . $shipping_code . '.php';

        if (file_exists($path)) {
            include_once($path);

            $shipping = new $shipping_code;
            $insure = floatval($insure) / 100;

            if (method_exists($shipping, 'calculate_insure')) {
                return $shipping->calculate_insure($goods_amount, $insure);
            } else {
                return ceil($goods_amount * $insure);
            }
        } else {
            return false;
        }
    }
}

/**
 * 获得订单需要支付的支付费用
 *
 * @access  public
 * @param   integer $payment_id

 * @param   float   $order_amount

 * @param   mix     $cod_fee

 * @return  float

 */

function pay_fee($payment_id, $order_amount, $cod_fee = null) {

    $pay_fee = 0;

    $payment = model('Order')->payment_info($payment_id);

    $rate = ($payment['is_cod'] && !is_null($cod_fee)) ? $cod_fee : $payment['pay_fee'];



    if (strpos($rate, '%') !== false) {

        /* 支付费用是一个比例 */

        $val = floatval($rate) / 100;

        $pay_fee = $val > 0 ? $order_amount * $val / (1 - $val) : 0;

    } else {

        $pay_fee = floatval($rate);

    }



    return round($pay_fee, 2);

}



/**

 * 根据订单中的商品总额来获得包装的费用

 *

 * @access  public

 * @param   integer $pack_id

 * @param   float   $goods_amount

 * @return  float

 */

function pack_fee($pack_id, $goods_amount) {

    $pack = model('Order')->pack_info($pack_id);



    $val = (floatval($pack['free_money']) <= $goods_amount && $pack['free_money'] > 0) ? 0 : floatval($pack['pack_fee']);



    return $val;

}



/**

 * 根据订单中商品总额获得需要支付的贺卡费用

 *

 * @access  public

 * @param   integer $card_id

 * @param   float   $goods_amount

 * @return  float

 */

function card_fee($card_id, $goods_amount) {

    $card = model('Order')->card_info($card_id);



    return ($card['free_money'] <= $goods_amount && $card['free_money'] > 0) ? 0 : $card['card_fee'];

}



/**

 * 判断订单是否已完成

 * @param   array   $order  订单信息

 * @return  bool

 */

function order_finished($order) {

    return $order['order_status'] == OS_CONFIRMED &&

            ($order['shipping_status'] == SS_SHIPPED || $order['shipping_status'] == SS_RECEIVED) &&

            ($order['pay_status'] == PS_PAYED || $order['pay_status'] == PS_PAYING);

}



/**

 * 得到新订单号

 * @return  string

 */

function get_order_sn() {

    /* 选择一个随机的方案 */

    mt_srand((double) microtime() * 1000000);



    return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

}



/**

 * 计算积分的价值（能抵多少钱）

 * @param   int     $integral   积分

 * @return  float   积分价值

 */

function value_of_integral($integral) {

    $scale = floatval(C('integral_scale'));



    return $scale > 0 ? round(($integral / 100) * $scale, 2) : 0;

}



/**

 * 计算指定的金额需要多少积分

 *

 * @access  public

 * @param   integer $value  金额

 * @return  void

 */

function integral_of_value($value) {

    $scale = floatval(C('integral_scale'));



    return $scale > 0 ? round($value / $scale * 100) : 0;

}



/**

 * 获取配送插件的实例

 * @param   int   $shipping_id    配送插件ID

 * @return  object     配送插件对象实例

 */

function &get_shipping_object($shipping_id) {

    $shipping = model('Shipping')->shipping_info($shipping_id);

    if (!$shipping) {

        $object = new stdClass();

        return $object;

    }

    $file_path = ROOT_PATH . 'plugins/shipping/' . $shipping['shipping_code'] . '.php';



    include_once($file_path);



    $object = new $shipping['shipping_code'];

    return $object;

}



/**

 * 生成查询订单的sql

 * @param   string  $type   类型

 * @param   string  $alias  order表的别名（包括.例如 o.）

 * @return  string

 */

function order_query_sql($type = 'finished', $alias = '') {

    /* 已完成订单 */

    if ($type == 'finished') {

        return " AND {$alias}order_status " . db_create_in(array(OS_CONFIRMED, OS_SPLITED)) .

                " AND {$alias}shipping_status " . db_create_in(array(SS_SHIPPED, SS_RECEIVED)) .

                " AND {$alias}pay_status " . db_create_in(array(PS_PAYED, PS_PAYING)) . " ";

    }

    /* 待发货订单 */ elseif ($type == 'await_ship') {

        return " AND   {$alias}order_status " .

                db_create_in(array(OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART)) .

                " AND   {$alias}shipping_status " .

                db_create_in(array(SS_UNSHIPPED, SS_PREPARING, SS_SHIPPED_ING)) .

                " AND ( {$alias}pay_status " . db_create_in(array(PS_PAYED, PS_PAYING)) . " OR {$alias}pay_id " . db_create_in(model('Order')->payment_id_list(true)) . ") ";

    }

    /* 待付款订单 */ elseif ($type == 'await_pay') {

        return " AND   {$alias}order_status " . db_create_in(array(OS_CONFIRMED, OS_SPLITED)) .

                " AND   {$alias}pay_status = '" . PS_UNPAYED . "'" .

                " AND ( {$alias}shipping_status " . db_create_in(array(SS_SHIPPED, SS_RECEIVED)) . " OR {$alias}pay_id " . db_create_in(model('Order')->payment_id_list(false)) . ") ";

    }

    /* 未确认订单 */ elseif ($type == 'unconfirmed') {

        return " AND {$alias}order_status = '" . OS_UNCONFIRMED . "' ";

    }

    /* 未处理订单：用户可操作 */ elseif ($type == 'unprocessed') {

        return " AND {$alias}order_status " . db_create_in(array(OS_UNCONFIRMED, OS_CONFIRMED)) .

                " AND {$alias}shipping_status = '" . SS_UNSHIPPED . "'" .

                " AND {$alias}pay_status = '" . PS_UNPAYED . "' ";

    }

    /* 未付款未发货订单：管理员可操作 */ elseif ($type == 'unpay_unship') {

        return " AND {$alias}order_status " . db_create_in(array(OS_UNCONFIRMED, OS_CONFIRMED)) .

                " AND {$alias}shipping_status " . db_create_in(array(SS_UNSHIPPED, SS_PREPARING)) .

                " AND {$alias}pay_status = '" . PS_UNPAYED . "' ";

    }

    /* 已发货订单：不论是否付款 */ elseif ($type == 'shipped') {

        return " AND {$alias}order_status = '" . OS_CONFIRMED . "'" .

                " AND {$alias}shipping_status " . db_create_in(array(SS_SHIPPED, SS_RECEIVED)) . " ";

    } else {

        die('函数 order_query_sql 参数错误');

    }

}



/**

 * 生成查询订单总金额的字段

 * @param   string  $alias  order表的别名（包括.例如 o.）

 * @return  string

 */

function order_amount_field($alias = '') {

    return "   {$alias}goods_amount + {$alias}tax + {$alias}shipping_fee" .

            " + {$alias}insure_fee + {$alias}pay_fee + {$alias}pack_fee" .

            " + {$alias}card_fee ";

}



/**

 * 生成计算应付款金额的字段

 * @param   string  $alias  order表的别名（包括.例如 o.）

 * @return  string

 */

function order_due_field($alias = '') {

    return order_amount_field($alias) .

            " - {$alias}money_paid - {$alias}surplus - {$alias}integral_money" .

            " - {$alias}bonus - {$alias}discount ";

}



/**

 * 得到新发货单号

 * @return  string

 */

function get_delivery_sn() {

    /* 选择一个随机的方案 */

    mt_srand((double) microtime() * 1000000);



    return date('YmdHi') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

}



/* * ********************************************************

 * 用户帐号相关函数库

 * ******************************************************** */



/**

 *

 *

 * @access  public

 * @param

 *

 * @return void

 */

function logout() {

    /* todo */

}



/**

 *  将指定user_id的密码修改为new_password。可以通过旧密码和验证字串验证修改。

 *

 * @access  public

 * @param   int     $user_id        用户ID

 * @param   string  $new_password   用户新密码

 * @param   string  $old_password   用户旧密码

 * @param   string  $code           验证码（md5($user_id . md5($password))）

 *

 * @return  boolen  $bool

 */

function edit_password($user_id, $old_password, $new_password = '', $code = '') {

    if (empty($user_id))

        ECTouch::err()->add(L('not_login'));



    if (ECTouch::user()->edit_password($user_id, $old_password, $new_password, $code)) {

        return true;

    } else {

        ECTouch::err()->add(L('edit_password_failure'));



        return false;

    }

}



/**

 *  会员找回密码时，对输入的用户名和邮件地址匹配

 *

 * @access  public

 * @param   string  $user_name    用户帐号

 * @param   string  $email        用户Email

 *

 * @return  boolen

 */

function check_userinfo($user_name, $email) {

    if (empty($user_name) || empty($email)) {

        ecs_header("Location: user.php?act=get_password\n");



        exit;

    }



    /* 检测用户名和邮件地址是否匹配 */

    $user_info = ECTouch::user()->check_pwd_info($user_name, $email);

    if (!empty($user_info)) {

        return $user_info;

    } else {

        return false;

    }

}



/**

 *  用户进行密码找回操作时，发送一封确认邮件

 *

 * @access  public

 * @param   string  $uid          用户ID

 * @param   string  $user_name    用户帐号

 * @param   string  $email        用户Email

 * @param   string  $code         key

 *

 * @return  boolen  $result;

 */

function send_pwd_email($uid, $user_name, $email, $code) {

    if (empty($uid) || empty($user_name) || empty($email) || empty($code)) {

        ecs_header("Location: " . url('user/get_password_phone') . "\n");



        exit;

    }



    /* 设置重置邮件模板所需要的内容信息 */

    $template = model('Base')->get_mail_template('send_password');

    $reset_email = __HOST__ . url('user/get_password_email', array('uid' => $uid, 'code' => $code));



    ECTouch::view()->assign('user_name', $user_name);

    ECTouch::view()->assign('reset_email', $reset_email);

    ECTouch::view()->assign('shop_name', C('shop_name'));

    ECTouch::view()->assign('send_date', date('Y-m-d'));

    ECTouch::view()->assign('sent_date', date('Y-m-d'));



    $content = ECTouch::view()->fetch('str:' . $template['template_content']);



    /* 发送确认重置密码的确认邮件 */

    if (send_mail($user_name, $email, $template['template_subject'], $content, $template['is_html'])) {

        return true;

    } else {

        return false;

    }

}



/* * ********************************************************

 * 支付接口函数库

 * ******************************************************** */



/**

 * 取得返回信息地址

 * @param   string  $code   支付方式代码

 * @param   string  $params  必须有type值, $params = array('type'=>0), 0 同步，1 异步

 */

function return_url($code = '', $params = array()) {

    $params['code'] = $code;

    $base64 = urlsafe_b64encode(serialize($params));

    return __URL__ . '/respond.php?code=' . $base64;

}



//url base64编码

function urlsafe_b64encode($string)

{

    $data = base64_encode($string);

    $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);

    return $data;

}



//url base64解码

function urlsafe_b64decode($string)

{

    $data = str_replace(array('-', '_'), array('+', '/'), $string);

    $mod4 = strlen($data) % 4;

    if ($mod4) {

        $data .= substr('====', $mod4);

    }

    return base64_decode($data);

}



/* * ********************************************************

 * 用户交易相关函数库

 * ******************************************************** */



/**

 * 获得会员的团购活动列表

 *

 * @access  public

 * @param   int         $user_id         用户ID

 * @param   int         $num             列表显示条数

 * @param   int         $start           显示起始位置

 *

 * @return  array       $arr             团购活动列表

 */

function get_user_group_buy($user_id, $num = 10, $start = 0) {

    return true;

}



/**

 * 获得团购详细信息(团购订单信息)

 *

 *

 */

function get_group_buy_detail($user_id, $group_buy_id) {

    return true;

}



/**

 * 去除虚拟卡中重复数据

 *

 *

 */

function deleteRepeat($array) {

    $_card_sn_record = array();

    foreach ($array as $_k => $_v) {

        foreach ($_v['info'] as $__k => $__v) {

            if (in_array($__v['card_sn'], $_card_sn_record)) {

                unset($array[$_k]['info'][$__k]);

            } else {

                array_push($_card_sn_record, $__v['card_sn']);

            }

        }

    }

    return $array;

}



/* * ********************************************************

 * UCenter 函数库

 * ******************************************************** */



/**

 * 通过判断is_feed 向UCenter提交Feed

 *

 * @access public

 * @param  integer $value_id  $order_id or $comment_id

 * @param  interger $feed_type BUY_GOODS or COMMENT_GOODS

 *

 * @return void

 */

function add_feed($id, $feed_type) {

    $feed = array();

    if ($feed_type == BUY_GOODS) {

        if (empty($id)) {

            return;

        }

        $id = intval($id);

        $order_res = M()->query("SELECT g.goods_id, g.goods_name, g.goods_sn, g.goods_desc, g.goods_thumb, o.goods_price FROM " . M()->pre . 'order_goods ' . " AS o, " . M()->pre . 'goods ' . " AS g WHERE o.order_id='{$id}' AND o.goods_id=g.goods_id");

        foreach ($order_res as $goods_data) {

            if (!empty($goods_data['goods_thumb'])) {

                $url = __URL__ . $goods_data['goods_thumb'];

            } else {

                $url = __URL__ . C('no_picture');

            }

            $link = __URL__ . "goods.php?id=" . $goods_data["goods_id"];



            $feed['icon'] = "goods";

            $feed['title_template'] = '<b>{username} ' . L('feed_user_buy') . ' {goods_name}</b>';

            $feed['title_data'] = array('username' => $_SESSION['user_name'], 'goods_name' => $goods_data['goods_name']);

            $feed['body_template'] = '{goods_name}  ' . L('feed_goods_price') . ':{goods_price}  ' . L('feed_goods_desc') . ':{goods_desc}';

            $feed['body_data'] = array('goods_name' => $goods_data['goods_name'], 'goods_price' => $goods_data['goods_price'], 'goods_desc' => sub_str(strip_tags($goods_data['goods_desc']), 150, true));

            $feed['images'][] = array('url' => $url, 'link' => $link);

            uc_call("uc_feed_add", array($feed['icon'], $_SESSION['user_id'], $_SESSION['user_name'], $feed['title_template'], $feed['title_data'], $feed ['body_template'], $feed['body_data'], '', '', $feed['images']));

        }

    }

    return;

}



/**

 * 获得商品tag所关联的其他应用的列表

 *

 * @param   array       $attr

 *

 * @return  void

 */

function get_linked_tags($tag_data) {

    //取所有应用列表

    $app_list = uc_call("uc_app_ls");

    if ($app_list == '') {

        return '';

    }

    foreach ($app_list as $app_key => $app_data) {

        if ($app_data['appid'] == UC_APPID) {

            unset($app_list[$app_key]);

            continue;

        }

        $get_tag_array[$app_data['appid']] = '5';

        $app_array[$app_data['appid']]['name'] = $app_data['name'];

        $app_array[$app_data['appid']]['type'] = $app_data['type'];

        $app_array[$app_data['appid']]['url'] = $app_data['url'];

        $app_array[$app_data['appid']]['tagtemplates'] = $app_data['tagtemplates'];

    }



    $tag_rand_key = array_rand($tag_data);

    $get_tag_data = uc_call("uc_tag_get", array($tag_data[$tag_rand_key], $get_tag_array));

    foreach ($get_tag_data as $appid => $tag_data_array) {

        $templates = $app_array[$appid]['tagtemplates']['template'];

        if (!empty($templates) && !empty($tag_data_array['data'])) {

            foreach ($tag_data_array['data'] as $tag_data) {

                $show_data = $templates;

                foreach ($tag_data as $tag_key => $data) {

                    $show_data = str_replace('{' . $tag_key . '}', $data, $show_data);

                }

                $app_array[$appid]['data'][] = $show_data;

            }

        }

    }



    return $app_array;

}



/**

 * 兑换积分

 *

 * @param  integer $uid 用户ID

 * @param  integer $fromcredits 原积分

 * @param  integer $tocredits 目标积分

 * @param  integer $toappid 目标应用ID

 * @param  integer $netamount 积分数额

 *

 * @return boolean

 */

function exchange_points($uid, $fromcredits, $tocredits, $toappid, $netamount) {

    $ucresult = uc_call('uc_credit_exchange_request', array($uid, $fromcredits, $tocredits, $toappid, $netamount));

    if (!$ucresult) {

        return false;

    } else {

        return true;

    }

}



/**

 * 微信提醒

 *

 * @param  $type 提醒类型

 * @param  $title 提醒标题

 * @param  $msg 提醒内容

 * @param  $url 页面链接 base64_decode(urldecode($url));

 * @param  $order_id 订单id 

 *

 */

function send_wechat_message($type = '', $title = '', $msg = '', $url = '', $order_id = '', $openid2 = '') {

    /* 如果需要，微信通知 wanglu */

    if (!empty($type)) {

        $remind = M()->table('wechat_extend')->field('name, config')->where('enable = 1 and command = "' . $type . '"')->find();

        // logResult(var_export($_SESSION, true));

        $config = unserialize($remind['config']);

        $title = $remind['name'] ? $remind['name'] : $title;

        $msg = $config['template'] ? str_replace('[$order_id]', $order_id, $config['template']) : $msg;

        $openid = M()->table('wechat_user')->field('openid')->where('ect_uid = ' . $_SESSION['user_id'])->getOne();



        $openid = !empty($openid2) ? $openid2 : $openid;

        if (!empty($title) && !empty($openid)) {

            $dourl = __HOST__ . url('api/index', array('openid' => $openid, 'title' => $title, 'msg' => $msg, 'url' => $url));

            $dourl = str_replace('notify_wap_wxpay', 'mobile/index', $dourl);

            Http::doGet($dourl);

        }

    }

}

/**
* 
* @param undefined $title  提醒标题
* @param undefined $msg  提醒内容
* @param undefined $url  点击提醒跳转的网址
* @param undefined $openid  微信唯一对应的openid  不填则自动获取当前登录用户的openid
* 
* @return  成功 success  失败 error  
*/

function send_tx_msg($title,$msg,$url,$openid=''){//发送提醒消息
	if(!$openid) $openid = M()->table('wechat_user')->field('openid')->where('ect_uid = ' . $_SESSION['user_id'])->getOne();
	if(!$openid) return 'error openid!';
	 $dourl = __HOST__ . url('api/index', array('openid' => $openid, 'title' => $title, 'msg' => $msg, 'url' => $url));
     $re = Http::doGet($dourl);
	 if(1){
	 	return 'success';
	 }else{
	 	return 'error';
	 }
	 
}

/**

 * 获取商品销量总数

 *

 * @access public

 * @param integer $goods_id

 * @return integer

 */

function get_goods_count($goods_id)

{

    /* 统计时间段 */

    $period = C('top10_time');

    $ext = '';

    if ($period == 1) {// 一年

        $ext = "AND o.add_time >'" . local_strtotime('-1 years') . "'";

    } elseif ($period == 2) {// 半年

        $ext = "AND o.add_time > '" . local_strtotime('-6 months') . "'";

    } elseif ($period == 3) {// 三个月

        $ext = " AND o.add_time > '" . local_strtotime('-3 months') . "'";

    } elseif ($period == 4) {// 一个月

        $ext = " AND o . add_time > '" . local_strtotime(' - 1 months') . "'";

    }

  /* 查询该商品销量 */

    $sql = 'SELECT IFNULL(SUM(g.goods_number), 0) as count ' .

        'FROM '. M()->pre .'order_info AS o, '. M()->pre .'order_goods AS g ' .

        "WHERE o . order_id = g . order_id " .

        " AND o . order_status " . db_create_in(array(OS_CONFIRMED, OS_SPLITED)) .

        " AND o . shipping_status " . db_create_in(array(SS_SHIPPED, SS_RECEIVED)) .

        " AND o . pay_status " . db_create_in(array(PS_PAYED, PS_PAYING)) .

        " AND g . goods_id = '$goods_id'";

    $result = M()->getRow($sql);

    return $result['count'];
}
/**
 * $upload_dir上传的目录名 
 * 
 */
function ectouchUpload($key = '', $upload_dir = 'images', $thumb = false, $width = 220, $height = 220) {
    $upload = new UploadFile();
    //设置上传文件大小
    $upload->maxSize = 1024 * 1024 * 2; //最大2M
    //设置上传文件类型
    $upload->allowExts = explode(',', 'jpg,jpeg,gif,png,bmp,mp3,amr,mp4');
    //生成缩略图
    $upload->thumb = $thumb;
    //缩略图大小
    $upload->thumbMaxWidth = $width;
    $upload->thumbMaxHeight = $height;

    //设置附件上传目录
    $upload->savePath = './data/attached/' . $upload_dir . "/";

    if (!$upload->upload($key)) {
        //捕获上传异常
        return array('error' => 1, 'message' => $upload->getErrorMsg());
    } else {
        //取得成功上传的文件信息
        return array('error' => 0, 'message' => $upload->getUploadFileInfo());
    }
}

function Upload_img($file_name = '', $upload_dir = 'images'){
    
    
    return $arr;
    
}
/**
 * 得到新服务单号
 * @return  string
 */
function get_service_sn() {
    /* 选择一个随机的方案 */
    mt_srand((double) microtime() * 1000000);

    return date('Ymd') . str_pad(mt_rand(1, 99999), 3, '0',STR_PAD_LEFT);
}



function get_token1($appid,$appsecret){//shanmao.me add 

if(!$appid || !$appsecret){
	 $wechat = model('Base')->model->table('wechat')

            ->field('id, token, appid, appsecret, oauth_redirecturi, type, oauth_status')

            ->where('default_wx = 1 and status = 1')

            ->find();
   $appid=$wechat['appid'];         
   $appsecret=$wechat['appsecret'];         
}

	if($_SESSION['access_tokens']) return $_SESSION['access_tokens'];

	$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;

        $ret_json = file_get_contents($url);
        $ret = json_decode($ret_json);
        if($ret -> access_token){  	
$_SESSION['access_tokens']=$ret->access_token;
			return $ret -> access_token;
		}



}	







function http_post1($url,$param,$post_file=false){

		$oCurl = curl_init();

		if(stripos($url,"https://")!==FALSE){


			curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);

			curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);


			curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1


		}



		if (is_string($param) || $post_file) {


			$strPOST = $param;


		} else {


			$aPOST = array();


			foreach($param as $key=>$val){


				$aPOST[] = $key."=".urlencode($val);

			}

			$strPOST =  join("&", $aPOST);

		}

		curl_setopt($oCurl, CURLOPT_URL, $url);

		curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );

		curl_setopt($oCurl, CURLOPT_POST,true);

		curl_setopt($oCurl, CURLOPT_POSTFIELDS,$strPOST);

		$sContent = curl_exec($oCurl);

		$aStatus = curl_getinfo($oCurl);

		curl_close($oCurl);

		if(intval($aStatus["http_code"])==200){

			return $sContent;


		}else{

			return false;

		}

}



    


function sendmb_order($title,$desc,$ordersn,$url,$openid=null){//发送通知模板消息   = 订单状态更新
if(!$openid) $openid = M()->table('wechat_user')->field('openid')->where('ect_uid = ' . $_SESSION['user_id'])->getOne();
if(!$openid) return 'error openid!';

	$json = '{
           "touser":"'.$openid.'",
           "template_id":"WsOG-qms0wRE5E6TqMIahPQTFEApHPAyG3ZhgMAeuPk",
           "url":"'.$url.'",
           "topcolor":"#FF0000",
           "data":{
                   "first": {
                       "value":"'.$title.'",
                       "color":"#173177"
                   },                   
                   "keyword1": {
                       "value":"'.$ordersn.'",
                       "color":"#173177"
                   },                   
                   "keyword2": {
                       "value":"'.date("Y-m-d H:i:s",time()).'",
                       "color":"#173177"
                   },                   
                   "remark":{
                       "value":"'.$desc.'",
                       "color":"#173177"
                   }
           }
       }';

	$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=". get_token1();
	 $re =  http_post1($url,$json); 
	// var_dump($re);
	 return $re;
	
}
    
function sendmb_user($title,$desc,$uname,$url,$openid=null){//发送通知模板消息   = 会员提醒
//if(!$openid) $openid = M()->table('wechat_user')->field('openid')->where('ect_uid = ' . $_SESSION['user_id'])->getOne();
//if(!$openid) return 'error openid!';

	$json = '{
           "touser":"'.$openid.'",
           "template_id":"MyKWYmVZdn9t9ue1spBxBZBkAvoCDGSyNaf2FRmi2xs",
           "url":"'.$url.'",
           "topcolor":"#FF0000",
           "data":{
                   "first": {
                       "value":"'.$title.'",
                       "color":"#173177"
                   },                   
                   "keyword1": {
                       "value":"'.$uname.'",
                       "color":"#173177"
                   },                   
                   "keyword2": {
                       "value":"'.date("Y-m-d H:i:s",time()).'",
                       "color":"#173177"
                   },                   
                   "remark":{
                       "value":"'.$desc.'",
                       "color":"#173177"
                   }
           }
       }';

	$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=". get_token1();
	 $re =  http_post1($url,$json); 
	// var_dump($re);
	 return $re;
	
}


function sendmb_pay_done($title,$amount,$goods_name,$desc,$url,$openid=null){////订单支付成功
if(!$openid) $openid = M()->table('wechat_user')->field('openid')->where('ect_uid = ' . $_SESSION['user_id'])->getOne();
if(!$openid) return 'error openid!';

	$json = '{
           "touser":"'.$openid.'",
           "template_id":"6cpWkvTTlzbN2xRhgkT-TGMaZktBIOp6mSKZSNCSdNE",
           "url":"'.$url.'",
           "topcolor":"#FF0000",
           "data":{
                   "first": {
                       "value":"'.$title.'",
                       "color":"#173177"
                   },                   
                   "orderMoneySum": {
                       "value":"'.$amount.'",
                       "color":"#173177"
                   },                   
                   "orderProductName": {
                       "value":"'.$goods_name.'",
                       "color":"#173177"
                   },                   
                   "Remark":{
                       "value":"'.$desc.'",
                       "color":"#173177"
                   }
           }
       }';

	$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=". get_token1();
	 $re =  http_post1($url,$json); 
	// var_dump($re);
	 return $re;
	
}

function sendmb_tixian_done($title,$amount,$desc,$url,$openid=null){//提现成功通知
if(!$openid) $openid = M()->table('wechat_user')->field('openid')->where('ect_uid = ' . $_SESSION['user_id'])->getOne();
if(!$openid) return 'error openid!';

	$json = '{
           "touser":"'.$openid.'",
           "template_id":"Lj1v5BpgxEn-EzpNvPyFpyq6mPBFmS8RscIA0r2cVl0",
           "url":"'.$url.'",
           "topcolor":"#FF0000",
           "data":{
                   "first": {
                       "value":"'.$title.'",
                       "color":"#173177"
                   },                   
                   "money": {
                       "value":"'.$amount.'",
                       "color":"#173177"
                   },                   
                   "timet": {
                       "value":"'.date("Y-m-d H:i:s",time()).'",
                       "color":"#173177"
                   },                   
                   "remark":{
                       "value":"'.$desc.'",
                       "color":"#173177"
                   }
           }
       }';

	$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=". get_token1();
	 $re =  http_post1($url,$json); 
	// var_dump($re);
	 return $re;
	
}function sendmb_jiesuan($title,$time,$amount,$url,$openid){//结算通知
	//if(!$openid) $openid = M()->table('wechat_user')->field('openid')->where('ect_uid = ' . $_SESSION['user_id'])->getOne();
	//if(!$openid) return 'error openid!';

	$json = '{
           "touser":"'.$openid.'",
           "template_id":"o_TN7CjcDYgEt6zdiOuWZc_95_8G9jDfkzaRcDbcVIY",
           "url":"'.$url.'",
           "topcolor":"#FF0000",
           "data":{
                   "first": {
                       "value":"'.$title.'",
                       "color":"#173177"
                   },
                   "keyword1": {
                       "value":"'.$time.'",
                       "color":"#173177"
                   },
                   "keyword2": {
                       "value":"'.$amount.'",
                       "color":"#173177"
                   },
                   "remark":{
                       "value":"'.$desc.'",
                       "color":"#173177"
                   }
           }
       }';

	$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=". get_token1();
	$re =  http_post1($url,$json);
	// var_dump($re);
	return $re;

}

function sendmb_tuiding($title,$jindu,$goods,$order_sn,$desc,$url,$openid=null){//售后服务处理进度通知
if(!$openid) $openid = M()->table('wechat_user')->field('openid')->where('ect_uid = ' . $_SESSION['user_id'])->getOne();
if(!$openid) return 'error openid!';

	$json = '{
           "touser":"'.$openid.'",
           "template_id":"s1KVIIQ1RLRe_slQwGcUAvE8_1YEQB1fPZo00iwrK4o",
           "url":"'.$url.'",
           "topcolor":"#FF0000",
           "data":{
                   "first": {
                       "value":"'.$title.'",
                       "color":"#173177"
                   },                   
                   "orderInfomation": {
                       "value":"'.$jindu.'",
                       "color":"#173177"
                   },                   
                   "orderProductName": {
                       "value":"'.$goods.'",
                       "color":"#173177"
                   },      
				   "orderName": {
                       "value":"'.$order_sn.'",
                       "color":"#173177"
                   },     
                   "remark":{
                       "value":"'.$desc.'",
                       "color":"#173177"
                   }
           }
       }';

	$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=". get_token1();
	 $re =  http_post1($url,$json); 
	// var_dump($re);
	 return $re;
	
}

function sendmb_level_change($title,$org_level,$cur_level,$uname,$url,$openid=null){//会员级别变更提醒
if(!$openid) $openid = M()->table('wechat_user')->field('openid')->where('ect_uid = ' . $_SESSION['user_id'])->getOne();
if(!$openid) return 'error openid!';

	$json = '{
           "touser":"'.$openid.'",
           "template_id":"T4e--xg4F9pEw0Y8wFkRihmIe6Wa8jcK8to7balqMug",
           "url":"'.$url.'",
           "topcolor":"#FF0000",
           "data":{
                   "first": {
                       "value":"'.$title.'",
                       "color":"#173177"
                   },                   
                   "grade1": {
                       "value":"'.$org_level.'",
                       "color":"#173177"
                   },    
				   "grade2": {
                       "value":"'.$cur_level.'",
                       "color":"#173177"
                   },                
                   "time": {
                       "value":"'.date("Y-m-d H:i:s",time()).'",
                       "color":"#173177"
                   },                   
                   "remark":{
                       "value":"'.$desc.'",
                       "color":"#173177"
                   }
           }
       }';

	$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=". get_token1();
	 $re =  http_post1($url,$json); 
	// var_dump($re);
	 return $re;
	
}

function sendmb_commission($title,$amount,$desc,$url,$openid=null){//佣金提醒
//if(!$openid) $openid = M()->table('wechat_user')->field('openid')->where('ect_uid = ' . $_SESSION['user_id'])->getOne();
//if(!$openid) return 'error openid!';

	$json = '{
           "touser":"'.$openid.'",
           "template_id":"9eowRWkhQ5SZVi60_6I_-lDbBRPkXHfDoewjZW1Y030",
           "url":"'.$url.'",
           "topcolor":"#FF0000",
           "data":{
                   "first": {
                       "value":"'.$title.'",
                       "color":"#173177"
                   },                   
                   "keyword1": {
                       "value":"'.$amount.'",
                       "color":"#173177"
                   },                   
                   "keyword2": {
                       "value":"'.date("Y-m-d H:i:s",time()).'",
                       "color":"#173177"
                   },                   
                   "remark":{
                       "value":"'.$desc.'",
                       "color":"#173177"
                   }
           }
       }';

	$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=". get_token1();
	 $re =  http_post1($url,$json); 
	// var_dump($re);
	 return $re;
	
}

function sendmb_neworder($order_sn,$order_goods,$order_amount, $order_buyer,$order_address,$order_note,$desc,$url,$openid=null){//新订单提醒
if(!$openid) $openid = M()->table('wechat_user')->field('openid')->where('ect_uid = ' . $_SESSION['user_id'])->getOne();
if(!$openid) return 'error openid!';

	$json = '{
           "touser":"'.$openid.'",
           "template_id":"_lqobFLHNKaDrDIVMUfGDzNw1_ZLbNGcyv5Q7vOUR94",
           "url":"'.$url.'",
           "topcolor":"#FF0000",
           "data":{
                   "first": {
                       "value":"'.$order_sn.'",
                       "color":"#173177"
                   },                   
                   "keyword1": {
                       "value":"'.$order_goods.'",
                       "color":"#173177"
                   },                   
                   "keyword2": {
                       "value":"'.$order_amount.'",
                       "color":"#173177"
                   },     
				   "keyword3": {
                       "value":"'.$order_buyer.'",
                       "color":"#173177"
                   },                   
                   "keyword4": {
                       "value":"'.$order_address.'",
                       "color":"#173177"
                   },   
				   "keyword5": {
                       "value":"'.$order_note.'",
                       "color":"#173177"
                   },             
                   "remark":{
                       "value":"'.$desc.'",
                       "color":"#173177"
                   }
           }
       }';

	$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=". get_token1();
	 $re =  http_post1($url,$json); 
	// var_dump($re);
	 return $re;
	
}


/**

 * 生成快递100查询接口链接

 *

 * @param  $shipping_name 快递公司

 * @param  $order_sn 快递单号

 * @param  $return json

 *

**/

function shipping($shipping_name,$order_sn){
	
	$typeCom = $shipping_name;//快递公司
	$typeNu = $order_sn;  //快递单号


	switch ($typeCom){
		case "EMS"://ecshop后台中显示的快递公司名称
			$postcom = 'ems';//快递公司代码
			break;
		case "中国邮政":
			$postcom = 'ems';
			break;
		case "申通快递":
			$postcom = 'shentong';
			break;
		case "圆通速递":
			$postcom = 'yuantong';
			break;
		case "顺丰速运":
			$postcom = 'shunfeng';
			break;
		case "天天快递":
			$postcom = 'tiantian';
			break;
		case "韵达快递":
			$postcom = 'yunda';
			break;
		case "中通快递":
			$postcom = 'zhongtong';
			break;
		case "龙邦物流":
			$postcom = 'longbanwuliu';
			break;
		case "宅急送":
			$postcom = 'zhaijisong';
			break;
		case "全一快递":
			$postcom = 'quanyikuaidi';
			break;
		case "汇通速递":
			$postcom = 'huitongkuaidi';
			break;	
		case "民航快递":
			$postcom = 'minghangkuaidi';
			break;	
		case "亚风速递":
			$postcom = 'yafengsudi';
			break;	
		case "快捷速递":
			$postcom = 'kuaijiesudi';
			break;	
		case "华宇物流":
			$postcom = 'tiandihuayu';
			break;	
		case "中铁快运":
			$postcom = 'zhongtiewuliu';
			break;		
		case "FedEx":
			$postcom = 'fedex';
			break;		
		case "UPS":
			$postcom = 'ups';
			break;		
		case "DHL":
			$postcom = 'dhl';
			break;		
		default:
			$postcom = '';
	}
	///$AppKey='5737a76fcaba8850';//请将XXXXXX替换成您在http://kuaidi100.com/app/reg.html申请到的KEY
	//$url ='http://api.kuaidi100.com/api?id='.$AppKey.'&com='.$typeCom.'&nu='.$typeNu.'&show=0&muti=1&order=desc';
	$url ="http://m.kuaidi100.com/query?type=".$postcom."&id=1&postid=".$typeNu.'&show=0&muti=1&order=desc';

	//请勿删除变量$powered 的信息，否者本站将不再为你提供快递接口服务。
	$powered = '查询数据由：<a href="http://kuaidi100.com" target="_blank">KuaiDi100.Com （快递100）</a> 网站提供 ';


	//优先使用curl模式发送数据
	if (function_exists('curl_init') == 1){
	  $curl = curl_init();
	  curl_setopt ($curl, CURLOPT_URL, $url);
	  curl_setopt ($curl, CURLOPT_HEADER,0);
	  curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
	  curl_setopt ($curl, CURLOPT_TIMEOUT,5);
	  $get_content = curl_exec($curl);
	  curl_close ($curl);
	}else{
	  include("../common/snoopy.php");
	  $snoopy = new snoopy();
	  $snoopy->referer = 'http://www.google.com/';//伪装来源
	  $snoopy->fetch($url);
	  $get_content = $snoopy->results;
	}
	
	return $get_content;
}

	/*   
	* 功能：PHP图片水印 (水印支持图片或文字)   
	* 参数：   
	*     $groundImage  背景图片:即需要加水印的图片，暂只支持GIF,JPG,PNG格式；   
	*     $waterPos     水印位置:有10种状态，0为随机位置；   
	*                 	1为顶端居左，2为顶端居中，3为顶端居右；   
	*                 	4为中部居左，5为中部居中，6为中部居右；   
	*                 	7为底端居左，8为底端居中，9为底端居右；   
	*     $waterImage   图片水印:即作为水印的图片，暂只支持GIF,JPG,PNG格式；   
	*     $waterText    文字水印:即把文字作为为水印，支持ASCII码，不支持中文；   
	*     $textFont     文字大小:值为1、2、3、4或5，默认为5；   
	*     $textColor    文字颜色:值为十六进制颜色值，默认为#FF0000(红色)；   
	*   
	* 注意：Support GD 2.0，Support FreeType、GIF Read、GIF Create、JPG 、PNG   
	*     $waterImage 和 $waterText 最好不要同时使用，选其中之一即可，优先使用 $waterImage。   
	*     当$waterImage有效时，参数$waterString、$stringFont、$stringColor均不生效。   
	*     加水印后的图片的文件名和 $groundImage 一样。   
	* 作者：longware @ 2004-11-3 14:15:13
	*/   

	function imageWaterMark($groundImage,$waterPos=0,$waterImage="",$post_w="0",$post_h="0",$waterText="",$textFont=5,$textColor="#000000"){    
		$isWaterImage = FALSE;    
		$formatMsg = "二维码生成失败，请关注官方微信,再重试";    
		
	  //读取水印文件    
		if(!empty($waterImage) && file_exists($waterImage)){    
			$isWaterImage = TRUE;    
			$water_info = getimagesize($waterImage);    
			$water_w   = $water_info[0];//取得水印图片的宽    
			$water_h   = $water_info[1];//取得水印图片的高    

			switch($water_info[2]){ //取得水印图片的格式
				case 1:$water_im = imagecreatefromgif($waterImage);break;    
				case 2:$water_im = imagecreatefromjpeg($waterImage);break;    
				case 3:$water_im = imagecreatefrompng($waterImage);break;    
				default:die($formatMsg);    
			}    
		}    

		//读取背景图片    
		if(!empty($groundImage) && file_exists($groundImage)){    
			$ground_info = getimagesize($groundImage);    
			$ground_w   = $ground_info[0];//取得背景图片的宽    
			$ground_h   = $ground_info[1];//取得背景图片的高    

			switch($ground_info[2]){     //取得背景图片的格式
				case 1:$ground_im = imagecreatefromgif($groundImage);break;    
				case 2:$ground_im = imagecreatefromjpeg($groundImage);break;    
				case 3:$ground_im = imagecreatefrompng($groundImage);break;    
				default:die($formatMsg);    
			}    
		}else{    
			die("需要加水印的图片不存在！");    
		}    

		//水印位置    
		if($isWaterImage){  //图片水印  
			$w = $water_w;    
			$h = $water_h;    
			$label = "图片的";    
		}else{ //文字水印

			$temp = imagettfbbox(ceil($textFont*5),0,"./images/poster/msyhbd.ttf",$waterText);//取得使用 TrueType 字体的文本的范围    
			$w = $temp[2] - $temp[6];    
			$h = $temp[3] - $temp[7];    
			unset($temp);    
			$label = "文字区域";    
		}
		
		if( ($ground_w<$w) || ($ground_h<$h) ){    
			echo "需要加水印的图片的长度或宽度比水印".$label."还小，无法生成水印！";    
			return;    
		}
		switch($waterPos){    
		case 0://随机    
			$posX = rand(0,($ground_w - $w));    
			$posY = rand(0,($ground_h - $h));    
			break;    
		case 1://1为顶端居左    
			$posX = 0;    
			$posY = 0;    
			break;    
		case 2://2为顶端居中    
			$posX = ($ground_w - $w) / 2;    
			$posY = 0;    
			break;    
		case 3://3为顶端居右    
			$posX = $ground_w - $w;    
			$posY = 0;    
			break;    
		case 4://4为中部居左    
			$posX = 0;    
			$posY = ($ground_h - $h) / 2;    
			break;    
		case 5://5为中部居中    
			$posX = ($ground_w - $w) / 2;    
			$posY = ($ground_h - $h) / 2;    
			break;    
		case 6://6为中部居右    
			$posX = $ground_w - $w;    
			$posY = ($ground_h - $h) / 2;    
			break;    
		case 7://7为底端居左    
			$posX = 0;    
			$posY = $ground_h - $h;    
			break;    
		case 8://8为底端居中    
			$posX = ($ground_w - $w) / 2;    
			$posY = $ground_h - $h;    
			break;    
		case 9://9为底端居右    
			$posX = $ground_w - $w;    
			$posY = $ground_h - $h;    
			break;    
		case 10://
			$posX = $post_w;    
			$posY = $post_h;    
			break;      
		}    

		//设定图像的混色模式    
		imagealphablending($ground_im, true);    

		if($isWaterImage){   //图片水印  
			imagecopy($ground_im, $water_im, $posX, $posY, 0, 0, $water_w,$water_h);//拷贝水印到目标文件          
		}else{  //文字水印  
			if( !empty($textColor) && (strlen($textColor)==7)){    
				$R = hexdec(substr($textColor,1,2));    
				$G = hexdec(substr($textColor,3,2));    
				$B = hexdec(substr($textColor,5));    
			}else{    
				die("水印文字颜色格式不正确！");    
			} 
			//$waterText = iconv("utf-8","gbk",$waterText);
			//$waterText = iconv('GB2312','UTF-8','中文水印'); /*将 gb2312 的字符集转换成 UTF-8 的字符*/ 
			
			imagestring ( $ground_im, $textFont, $posX, $posY, $waterText, imagecolorallocate($ground_im, $R, $G, $B));          
		}    

		//生成水印后的图片    
		@unlink($groundImage);    
		switch($ground_info[2]){   //取得背景图片的格式 
			case 1:imagegif($ground_im,$groundImage);break;    
			case 2:imagejpeg($ground_im,$groundImage);break;    
			case 3:imagepng($ground_im,$groundImage);break;    
			default:die($errorMsg);    
		}    

		//释放内存    
		if(isset($water_info)) unset($water_info);    
		if(isset($water_im)) imagedestroy($water_im);    
		unset($ground_info);    
		imagedestroy($ground_im);    
	}
	
	/*   
	* 功能：缩放函数   
	* 参数：   
	*     $image   	背景图片，即需要加水印的图片，暂只支持GIF,JPG,PNG格式；   
	*     $path  	路径   
	*     $w   		缩放的宽度
	*     $h   		缩放的高 度
	*	  $type     缩放类型：1，按比例绽放；2，按固定大小缩放
	*     $pre   	缩放图片的前缀名
	*/   

	function mysf($image,$path,$w,$h,$type="1",$pre=''){
		//打开一个已有的图片资源
		//获取传进来的图片后缀
		$arr=explode('.',$image);
		//传进来的图片后缀
		$suffix=array_pop($arr);
		if($suffix == 'jpg'){
			$suffix='jpeg';
		}
		//定义打开图片的函数名称字符串
		$create='imagecreatefrom'.$suffix;
		//打开图片获取资源  变量函数
		$img=$create($image);
		//获取图像的宽高
		list($width,$height)=getimagesize($image);
		//计算缩放比例
		if($type == "1"){
			if($w/$width > $h/$height){
				$dw=$w;
				$dh=$height*($w/$width);
			}else{
				$dh=$h;
				$dw=$width*($h/$height);
			}
		}else{
			$dw = $w;
			$dh = $h;
		}
		
		//创建一个新画布
		$s_img = imagecreatetruecolor($dw+4,$dh+4);    //创建真彩图像资源
		$color = imagecolorAllocate($s_img,255,255,255);   //分配一个灰色
		imagefill($s_img,0,0,$color);
		//$s_img = imagecreatetruecolor($dw,$dh);
		imagecolortransparent($s_img,$color);
		//执行缩放
		imagecopyresampled($s_img,$img,2,2,0,0,$dw,$dh,$width,$height);
		
		//判断要保存图片的路径是否存在
		if(!file_exists($path)){
			mkdir($path);
		}
		//拼接要保存的图片的路径信息以及图片名称
		$newPath=rtrim($path,'/');
		$path=$newPath.'/'.$pre.basename($image);
		//保存图片
		$type='image'.$suffix;
		$result = $type($s_img,$path);

		//摧毁资源
		imagedestroy($img);
		imagedestroy($s_img);
		if($result){
			return $path;
		}else{
			return false;
		}

	}