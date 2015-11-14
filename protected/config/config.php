<?php
/**
 *
 * @desc       config.php file.
 *
 * @author     Qiu Xincai <qiuxc@eileengrays.com>
 * @link       http://www.eileengrays.com/
 * @copyright  EileenGrays.Com 2013-2015
 * @license    http://www.eileengrays.com/
 */

return array(
    'aliExpress' => array(
        'endpoints' => array(),
        'stores' => array(
            'lb' => array(
                'appKey' => '5420714',
                'appSecret' => 'oGNrJtM0rTqy',
            ),
            'lc' => array(
                'appKey' => '3342324',
                'appSecret' => 'gx4kWRkKTlDA',
            ),
        )
    ),
    'amazon' => array(
        'stores' => array(
            'lb' => array(
                'AWS_SERVICE_URL' => 'https://mws.amazonservices.com/Orders/2013-09-01',
                'AWS_ACCESS_KEY_ID' => 'AKIAIGHWPHRK32XVYJHA',
                'AWS_SECRET_ACCESS_KEY' => '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',
                'APPLICATION_NAME' => 'PU_OA',
                'APPLICATION_VERSION' => 'PU_OA0.1',
                'MERCHANT_ID' => 'A2FL4LW6XYI6ZS',
                'MARKETPLACE_ID' => 'ATVPDKIKX0DER',
            )
        ),
    ),
    'ebay' => array(
        'stores' => array(
            'compatabilityLevel' => 873,
            'ebay_lightingcraft' => array(
                'userToken' => 'AgAAAA**AQAAAA**aAAAAA**rHl9VA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AGmYGlCZKEog6dj6x9nY+seQ**OpkCAA**AAMAAA**PLzQaJZStNkPK4y9mQZZ/Hd6GsHydhwXOJZiR4uevyWAGGAuSlbSupgRnIpatu4LORFtChYBuh9nuYvFay2WAiUm5hDzVCa25hmedlXT3RzyeO8IN8czYAJFDo0vL1mlwfYGEwQ/KAgd9P0/rEoRjwXQgxyP4fRoiLMspe+Rswy28vRDASxaVVpVb0XMWUvm1IZOJs1R3+UWx9NOty2BTlZtszSONmDfWckGZ5n2xy4ZuNnD1GYnz0y7k6V0z3Kvo91I0hXN1l4j+tqK6PT/ByFHLbq04KieQU+pLR6s5NSSCiN9BFlRO8dMb70aymt8Dk4uN49FJLLicPODrC1Xy7ESlbdj7Vhj4dLmRJvqcoISFaeopMoRQxxPZSSyuZ9Rjn4hf0sMUpqEiRAcfJiDzd+MwyiMDkgjTrD0rStyq8fRYC0VlrsBYG2YVq+pZI7MrlDeoWpFOXPB+xf6oRMmfTvpkeo18OckojiKXjnp9TNl43V4hmz+JEkYERj+C2wi4rSvYQLTnPktl5LDZe3TbooJWXbbAhfMlC6e+dZw7pZ5qHecv5gLu/AILQ4atB3g7qDCctbVCFbo5IGCUzY1GIYNdkHck4uAkYYJ/r9/JCQX3LAkV01hfpPdOu7iXZJKB9FY8m6tR8yYeYIkwWyaVkJh2AbeZjaaT1kuZQJdGyO1/wZVBb57jnG77GT9F6QIAoEsnrS0uInVP84CVTlXkg43guJ1WyjzkfYNKC8fwsXnkNGKd+Q39xgqxgFKqpau',
            ),
            'ebay_parrotuncle' => array(
                'userToken' => 'AgAAAA**AQAAAA**aAAAAA**tcmzUw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AGlISkDZeGpgydj6x9nY+seQ**W1ICAA**AAMAAA**8wHwYNALWx0ZijxxYsccBw/nc9/EAcDi2GGRJoN8NO6t4U146FriR/S6x4kCKywpBbC5gRpyTGK/ld5c2hoN6vQiNwIm5PmHTxmXa8bhDsDztefsxpR+HIhhbOBkRoXxQGfhkos5d03YNxfmFGRB7lQXL/9sl0VOzgMvWFw0XaM5AvesSs83efB7mk3JGFLDQEBTHnS5VbZD8ftGLmG5TMs6nT64dZeFooxlYozSy4+ibdvsDsl+ddIcr3e0u1VkQK+xuHO3jD7fCd7BTBmXWV/qXwvy33WxmwhfhRIMGruRW4+ExhE1UrteWMYAS1JyeeuO7nps2DWiY2WyRuAXxlJpxZK47vn9FwjAKfIUDnhXBPiep2odMw9PbqBc96oKYkfEbRRQQWXcrNFaR5GEgZfrNBB2Iahgmb7d5AWYvWOz+deOYXGZd9iuFEcrumyYXJIDwiMfgdnqwrxQzn5eY7rWjQFn/VbY29zpmFKfBXrZdG31mP+jRYxqZcfy2vdGG0ib/b1D7NNJQP1/X9IpqqcTPJ2iaTVGz3ABxwyzFB+x3lps4/lu5pPKg2srMnT2AvelLGWM93/l76BcsdRtlf5WvQI+H8h5oKyp3/WvthT+X7jKHcxkWQ0ia6PM1Htk1hXV7cwYRYcVOir+pFY7S0uLGiES28ulA/a905c++54kuUCC05G39s+yb3yrH9MG6Ha0kSPJ/oZpSvvxmezvyEW4CocHyt1Wb3eQIGi7zOiv0i6AddBhdH0wN5lmfDpL',
            ),
            'ebay_lampfair' => array(
                'userToken' => 'AgAAAA**AQAAAA**aAAAAA**EsizUw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AGlISkDpOLogmdj6x9nY+seQ**WlICAA**AAMAAA**qneo3tBjEQ5l1sDr/efMbl7Cb+2CMZZ1ukQ1/ZIZ4WqE94X+6GhzuvvyG+8z0fzezmf7kvQJ4ClDkdKn9O+G/7SKPPbbC3D/+PcXXtAjdxKfBHlgGM2fVFfukwC4cxIK4+2SyFU9o1n6nAYXzMlK6wtH18sG24Hqn16chOm4taFyNm4aC63mD4ZEA6smPXt3qc8GlIjObw3cj4n0TS3ykPT6HHMytd+45pz52Q0U3xaZ7sheneid8sUXO85yhnXiuczoLb9SdKdmvMGDUcTdQQx/SZfyH1jVY3SKN4zCcG6LrT4MB5GIhEw1AUL4alZn8rnP+kYOfnwnuo9Gbqq5Nl4GY+pal6XePmUAxXa3Lf/PUg6RF0KO2Zf+aKHcBwFXy1qtIycOMgOs2scDxl3kiQWw7tn7Dr2L4J26EBD/x4NNe1pjuXKL3hh9L1x67k2nRBKD3lSbFQERiyoP7KWQACu9feOhiC7HibSmae/xclfwxWkx60nEsmhGwUniNaWoOkD2Wx34HVx7GUA/FBPD7qsgWqszgDutbHcbvwtfec6nzDY4Hyph7DeA2wcK/WACkNEAqHHw9WrKzHxgrWJfjVXrDD4D1Vy9ddp8IcKXSRF5sgMtZxVJU1ZAJq++vLG1XnCviVBjX3RnOAtgYVwmLprJTvVBUtqv0svWB+fGyFC/hlzxxd1JatFgGAj85/yobII8ViVzd2fSEOSsefMCY+So4l39odC36FkXzlmaXgcHwzNKr0PFco2+uTVvjKyK',
            ),
            'ebay_nebulalight' => array(
                'userToken' => 'AgAAAA**AQAAAA**aAAAAA**SNmsVQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AHmIqjAJWAowudj6x9nY+seQ**Z+0CAA**AAMAAA**JYHfJtykcsqjT8JwNmHWfUjaOIIdAVxLkKXodmOLw3gX0UeszjvMU0zG22fv8Rv30SLkWncJ+x3pd3eq1E7DpbuBlqsPrZTLaAWp27VScYhQQuBSZoanqaXUbi7XaTyxaZ/FBdKxrS/GZpphg5XZEzoun6wIb75R3kXdlaG7p9JYYEsPHvQ9g01dcTixfLCTC+5GJNOp6MisIHUFjYg7DrxTPiZZbSnkFfCIkF+R7Kx9B3xvey5ZTtmNeo/ysWNSWjAQ1fppi/rM6u/PoQQFlqn7TokLFC7LPdjWmGB8cGvoZw8e5pPs54oAFPc8nQ+yKfPTKEflFWnUDpgNSj0IpP8ODfQG6quoEG3doMknUuWfMECVJpKZsORVU9wNmUUR27CNSNO70fttOVS8hUbkQ1C22bXru+LZ71SdlxvzQLvInzZu1nujWXuWXoM6MDWdIF9BJ8m1DQMEMFlYH2pahUqqAWtIQtb/JQ1o7W/xX2xTTLLQKvkjViDGnwHdPQvlfdxvd15jndK79jcbQtj6ngLt7MUlNsolk5gacwkJ3LH98j7fbaQKF9NF/sDucI3nmgfbaRmn+eWU/llJCCclGylTgHhhGMywhIVnD34BF8NuEZHWtGbJjKF6U83GcuGgQ6A7ahYmN2hmRLAeJAM4IgrJ8QNglYR4EqMuXFhJSKK1uHZEJYgQogqRSXlTbx/TtWMjwYVRMPqJvokeE10wonLJXcf3GQhetSvyeoo78x09frpT/Z7toU3r1SanyjZ4',
            ),
            'ebay_lampemonde' => array(
                'userToken' => 'AgAAAA**AQAAAA**aAAAAA**H9usVQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AHmIqiCJeDqAWdj6x9nY+seQ**ae0CAA**AAMAAA**vWVjtnFJZUiDBrJfowETVrYX0eyGO8TAj5SaX9ojXkVt5eWj54V4nSJTWVRBlFTPW6XLbv9BIropvJtahQu59YhP6ty5IXIeRWpSCE9B2noOjBbdYmPwjV0lT3nuXjENLEaWhd/4qvOFbQf1g+dXd6wfcFQcr8MAKV/h/G2C0LJaM0gMQJlreJ4sYTCdExg3M/FdD83WIyvV7pymh3Ise7tYfCLEhUnmzDf5Oql+7nVKcV8Z+0p7CxPwhfxEEu4guW3GP+Gdw97VjwLYfbPFuMXN306omEHSiiaH1fDwKr5P22hGaksRYvDbWW3xGtUYvnrJwaH4E29HJEImYh6a+7CPwnPB8rsedA7VQHQ41DwhF5kw/wtUr0ddgU26lniaRtm5Ys9AA3g9BmSc2Ef/4y4AkbZw891tBvt6/0/mpVTuaOmC4EJR+1ILytVBYJgIkh772f/kzu8fYuqHzaiBJxC2rr2QP+p/7HLT1ufZbBdEMe/Fwx+xDliWmDdjrFLJRHIbCh1oBHMyRsr2vbrYJl6ILH+/qUP4u0edjkjg222fYiY/HA+iFC0jzb+XGeSrhk9ynmqbTL70O9MtjDn4yNHN1gkGI33SgPeotIGXFnYlJcro/ugzLLIGzbtw7ByjgqfpRoBdlk127ZBgGR/6Q6YY6ZLZfldU91/zhKtXs5O+Ub9r/BGBIcZ57SNriMZf/BSHfnK025oAvxEWvc7nQ4XW6mbUm1kQRIqdaXjBeID+VcRZfx8VXl/5T0gzqvTF',
            ),
            'ebay_crazyseller' => array(
                'userToken' => 'AgAAAA**AQAAAA**aAAAAA**85ExVg**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AAkYujCZaDoA2dj6x9nY+seQ**PQ0DAA**AAMAAA**YkgYKaxLPgoOMERRV6Bq3nedUZu4aLPYXKdzi6H8sDrZsoNita8eTEAVx7LuTcmogWRFXewA9AwG7SN3jko8qgg/xI9IHAo0YwYxK2ugwQjovMPu8/qzoBCnQHozMElyLxpqe3ql6K8ab7zXaZNMi5qM1LzN/ve8Zy3YvviopQ3Ge71MGVg7m03lACf4h2lVUvlzogKsuiLh6F2wGPi80hAN+NlD3cvEpiT+bm5mDaQ1ZZYXX/CSXN0PupFkDtOJKQR58I4baWiVPgUew1H0bcUMwWr1I7dIveb2FjmPUILJplyTHIPPJwHqql4qisRxBjzSFk6+TcSL35789ZmIXdWhA0oUXAIT3u+DVVUrT8clV2eG6rgbz0D4j21ohZAhYxH8im2gK5IZQKG9fL1nsQ51N3/J29Ogxnvn5OY9LrFxBTi8OrPtbMcUJc0kX/mfG5sZFZxom3CORpH3gL5Tcyve7Lf0rd3sB8si1VUJywnxS5IRZwHo9IV3h8n16CiH/SFVgIVanvzffM9T432BnDHnMsGWEC3Qqhu3ceUVUtzdvcmAAtr2ZHNOxKr/9TIW8h4gdND+/QpKl87uDpt+HlfIZ+CBpC+IlJJTFyK2hswKyd2lriI/2K78d8KECwL5nI+82ZEiwrU71GMGAnEQxG23+N8mvYvv5d4jEXyn6fo3ZNRXIcrvl7p9r3aK1XmDIAubcx7o2Gc2+F4sUTejUeG/+S7zrmUMNYQNqAKxXfDlJi2iTgK1Sqh/DVZRiWLf',//Ó¢¹ú
            ),
            'ebay_crazybuyer' => array(
                'userToken' => 'AgAAAA**AQAAAA**aAAAAA**9JMxVg**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AAkYulDZaCow2dj6x9nY+seQ**Pg0DAA**AAMAAA**RWB3nNyDaOtn50DRur/L7HrhFTvrW70cIxoPGQ6izeMCz1SeOrw6zIXuNhDiBltP5beCec0FHgJ+hyc/9n2qYaUG7Wy4Kk6nl0X3r5mqXaUtfmzLJmxBPu2vFBdXNOWoCYXC5uPykryCRiKLvD2knaEbgBzLB7gBI5ba16DtweFAX9bXy0g7mZcFCE4raH23q0EbXGJ6R+5PF4XEbepb4Boy3j1uE5Ojlk9Nh3+jfm7mHQ8Lp9+AsT30L+6c0kEbOiyP0Z6aUGekOCqnJX0NJew2Jnzew/K8k77pA0sCHNgteBkbTc0PR84objWTuU7bktuTWhu9q+i7pkTKAtxgRh6VQqAcjoI6aTM2qIf/mDYFTgtL8cWIV5hJzVoh2hVutd7dK0EoLFm1h65jYf+IgNN4zBFoa5YTKQGY/sLCIUAHfN4eWVij/Y2swKXpN6UgANjTapcY0YzFlpoh05u/Lf0fIaG2jqA86rCTrj2y7f2hfNmShNvXiMuEZk80XC1H21MvP36U8sSQ4d2RpHEaPcomkXDNUpwBNU5ImViaUpTXqcbYdSdSAp/EuphdHgQOb03o5EJeNRhTAFieZFcX3l5bNUsp7MH47n1jbxOcNBSaQSdtyarJW2UzKG+84nzPy1arIsxhEegZU3EzEDgw9mHEUtnbukWERSXL+rq+Nkrc//XZ6t363xVlitYU9J5XEOm1iWu5Ly+9rMqbovHFUbULF9tmGxND6sydpbxNVhkyxYtUnfD6IUKgf0lg9hy6'  //°ÄÖŞ
            ),
            'sandbox' => array(
                'devID' => '78085b10-2bd6-48fc-8334-9276eaeb505a', // these prod keys are different from sandbox keys
                'appID' => 'BiJiHan34-d4a3-4123-bb7f-51c6c060e8c',
                'certID' => 'a7e10f63-614a-43ef-85f3-abd6d9094386',
                //set the Server to use (Sandbox or Production)
                'serverUrl' => 'https://api.sandbox.ebay.com/ws/api.dll', // server URL different for prod and sandbox
                //the token representing the eBay user to assign the call with
                'userToken' => 'AgAAAA**AQAAAA**aAAAAA**NxGyUw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4GhDJSEog6dj6x9nY+seQ**cuECAA**AAMAAA**QN1W5F7HBESI/folEDtrqjE39hbFFYODbtfNv2Xq9zrAaFzhmPHSOUcLZgFY8m+rDrK9XxtbuAkA840w4FpdkufvAdGTo6kDVC1w8paMcCpdVxdXgYInmHmZf1s0KKfFPoBfEkNuHaHKRVwg5KhYdDpE4ro98Acv+CbzIbKo/fYkM/fhiPdqnyO60ukGvywJI8sebCL+2ktal9nUhgznwFWbwJ3HAzLBjix9JY9J24OIQVcNqV3Lfy4Wuosh++Vwt04iv7twzl0iIYTdlaRV6gzqpRL+7FNBJzL001x81j6KADtYNJp7QnuvU8JwLQKzMsGRb1tLKT0ax7GrPl5F1HpKwm1+d7ictulQzErTSIzXxyccxaxWxXPZHir324ora50ZwY0NiXCxBR19kG1kU+f8r2MrvW+A1VhnTIXaUEfO56UdsnKCtAYhBu8aswC4TSILTFfw5UbN3NdJNkzyHer7jiF2UubFu4p42GHHx6n0Nchkk61WRfEEkJmCvkB92OzDQoQ5C0YW0nF/R+cHV6nYDieauJcjQgzMxgchPOnlLoTM/EnpKYXb3Ht5ByJtTcvEf7lT7XDjxwct6PF8iK1o5/WXsI0ZSPx0tLIP4DC6Plm0c7fXtDCBBMu5r8nSX0dMybk0fAnExJbQ9gjrfxkDta9yj5muNjeQAJY0fUk5+vla1q+LOU870O5k9IvUPpihbEbqdNyF1Sh64g/sJBe0F7Tm7Mio/7u8UpKbBse3wErziS2gkWDRBam0xVmF',
            ),
        )
    ),
    'magento' => array(
        'stores' => array()
    )

);