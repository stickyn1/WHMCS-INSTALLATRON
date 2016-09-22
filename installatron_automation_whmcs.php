<?php

function installatron_autoinstall($vars)
{
    // Exit if a hosting account is not being provisioned. We don't want to be here!
    if ( $vars["params"]["type"] !== "hostingaccount" )
    {
        return;
    }

    if(intval($vars["params"]["packageid"]) !== 2)
    {
        return;
    }

    if($vars["params"]["customfields"]["Theme"] === "divi")
    { 
        $contentid = "2wzimd6mgticcg4osc0sgk04g";
    }
    else if($vars["params"]["customfields"]["Theme"] === "extra")
    {
        $contentid = "1s0s8kkcso44g8ymk0o42vnrx";
    }
    else if($vars["params"]["customfields"]["Theme"] === "fitness")
    {
        $contentid = "cso44k8ym1s0s8kk02vnrxgo4";
    }
    else
    {
        return;
    }

    $query = array(
        "cmd"           => "install",
        "background"    => "yes",//execute as a background process
        "application"   => "wordpress",
        "url"           => "http://".$vars["params"]["domain"],
		"login"         => $vars["params"]["customfields"]["Username"],
        "passwd"        => $vars["params"]["customfields"]["Password"],
        "sitetitle"     => $vars["params"]["customfields"]["Title"],
        "content"       => $contentid,
    );

    $response = _installatron_call_v2($vars, $query);

    if ( $response["result"] === false )
    {
        error_log("Installatron API Error: ".var_export($response,true)."\nRequest: ".var_export($vars["params"],true), 3, "/tmp/whmcs_installatron_error_log");
        return;
    }

    // Success!
    //echo $response["message"];

}

add_hook("AfterModuleCreate", 9, "installatron_autoinstall");

?>  
