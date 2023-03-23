<style>
    #share-bar {
        display: block;
        position: fixed;
        top: 50%;
        transform: translateY(-50%);
        z-index: 9999;
    }

    .sharing-providers {
        list-style-type: none;
        text-align: center;
        padding: 0;
        margin: 0;
    }

    .sharing-providers > li {
        display: block;
        text-align: center;
        width: 45px;
        height: 45px;
        padding: 0;
        margin: 0;
        background: #777777;
        transition: 0.5s all;
    }
    .sharing-providers.circle > li {
        border-radius: 50%;
        margin: 2px;
        text-align: center;

    }
    #share-bar.left {
        left: 0;
    }
    #share-bar.left .sharing-providers > li {
        margin-left: 0;
    }
    #share-bar.right {
        right: 0;
    }
    #share-bar.right .sharing-providers > li {
        margin-right: 0;
    }

    .sharing-providers > li > a {
        text-decoration: none !important;
        font-family: 'FontAwesome';
        width: 45px;
        height: 45px;
        line-height: 45px;
        display: block;
        text-align: center;

    }
    .sharing-providers.circle > li > a {
        border-radius: 50%;
    }
    .sharing-providers > li > a {
        color: white;
        font-size: 25px;
    }
    .sharing-providers > li > a,
    .sharing-providers > li > a:hover {
        text-decoration: none;
    }

    #share-bar.animate .sharing-providers > li:hover {
        transform: translateX(5px);
    }

    #share-bar.right.animate .sharing-providers > li:hover {
        transform: translateX(-5px);
    }

    .sharing-providers > li.facebook:hover {
        background: #4267B2;

    }

    .sharing-providers > li.googleplus:hover {
        background: #d14836;
    }

    .sharing-providers > li.twitter:hover {
        background: #1DA1F2;
    }

    .sharing-providers > li.linkedin:hover {
        background: #0077B5;
    }

    .sharing-providers > li.tumblr:hover {
        background: #2c4762;
    }

    .sharing-providers > li.digg:hover {
        background: #333333;
    }

    .sharing-providers > li.reddit:hover {
        background: #5f99cf;
    }

    .sharing-providers > li.pinterest:hover {
        background: #cb2027;
    }

    .sharing-providers > li.stumbleupon:hover {
        background: #EB4924;
    }

    .sharing-providers > li.email:hover {
        background: #E3A129;
    }

    @media (max-width: 680px) {
        #share-bar {
            bottom: 0;
            top: auto;
            transform: translate(-50%, 0);
            left: 50% !important;
            right: auto;
            background: white;
            width: 100%;
            text-align: center;
            padding: 8px;
        }
        #share-bar .sharing-providers > li {
            display: inline-block;
        }
        #share-bar.animate .sharing-providers > li:hover {
            transform: translateX(0px) !important;
            transform: translateY(-5px) !important;
        }
    }
</style>
<div id="share-bar"></div>
