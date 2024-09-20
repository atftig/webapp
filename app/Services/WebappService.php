<?php

namespace App\Services;

use App\Models\ProductMediaIntranet;
use App\Models\UserIntranet;
use App\Models\ProductDetailIntranet;
use App\Models\ProductMedia;
use App\Models\User;
use App\Models\ProductDetail;

/**
 * Class webappService.
 */
class WebappService
{


    public function Webapp()
    {

        $webappMedia = ProductMedia::select('select * from product_media');
        $webappDetail = ProductDetail::select('select * from product_detail');
        $webappUser = User::select('select * from user');
    }

}
