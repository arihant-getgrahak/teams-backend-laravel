<?php

return [

    // 'group' =>
    //     [
    //         'name.required' => 'समूह नाम फ़ील्ड आवश्यक है|',
    //         'name.max' => 'समूह नाम 255 अक्षरों से कम होना चाहिए|',
    //         'name.string' => 'नाम एक स्ट्रिंग होना चाहिए|',
    //     ],

    // 'message' =>
    //     [
    //         'message.required' => 'संदेश फ़ील्ड आवश्यक है|',
    //         'message.max' => 'संदेश 255 अक्षरों से कम होना चाहिए|',
    //         'message_id.exists' => 'जिस संदेश को आप हटाने का प्रयास कर रहे हैं वह मौजूद नहीं है|',
    //         'message_id.string' => 'संदेश आईडी स्ट्रिंग प्रकार की है|',
    //         "message_id.required" => "आप जिस संदेश को अद्यतन करने का प्रयास कर रहे हैं वह आवश्यक है|",
    //         "message.string" => "संदेश एक स्ट्रिंग होना चाहिए.|",
    //     ],

    // 'invite' =>
    //     [
    //         "invitedTo.required" => "InvitedTo फ़ील्ड आवश्यक है|",
    //         "invitedBy.required" => "InvitedBy फ़ील्ड आवश्यक है|",
    //         "invitedBy.exists" => "InvitedBy मौजूद नहीं है|",
    //         "invitedTo.exists" => "InvitedTo मौजूद नहीं है|",
    //         "organization_id.required" => "संगठन_आईडी फ़ील्ड आवश्यक है|",
    //         "organization_id.exists" => "संगठन_आईडी मौजूद नहीं है|",
    //     ],

    // 'meeting' =>
    //     [
    //         'scheduled_at.required' => 'निर्धारित समय आवश्यक है|',
    //         'agenda.required' => 'एजेंडा आवश्यक है|',
    //         'agenda.max' => 'एजेंडा बहुत लंबा है|',
    //     ],

    // 'receiver' =>
    //     [
    //         'receiver_id.exists' => 'जिस उपयोगकर्ता को आप संदेश भेजने का प्रयास कर रहे हैं वह मौजूद नहीं है|',
    //         'receiver_id.required' => 'जिस उपयोगकर्ता को आप संदेश भेजने का प्रयास कर रहे हैं वह आवश्यक है|',
    //         'receiver_id.string' => 'जिस उपयोगकर्ता को आप संदेश भेजने का प्रयास कर रहे हैं वह एक स्ट्रिंग होना चाहिए|',
    //     ],

    // 'type' =>
    //     [
    //         'type.in' => 'आप जिस प्रकार को भेजने का प्रयास कर रहे हैं वह मान्य नहीं है|',
    //         "type.required" => "जिस प्रकार को आप भेजने का प्रयास कर रहे हैं वह आवश्यक है|",
    //     ],

    // 'description' =>
    //     [
    //         'description.required' => 'विवरण आवश्यक है|',
    //         'description.max' => 'विवरण बहुत लंबा है|',
    //         'description.string' => 'विवरण एक स्ट्रिंग होना चाहिए|',
    //     ],

    "required" => ':attribute फ़ील्ड आवश्यक है|',
    "unique" => ":attribute पहले ही ली जा चुकी है|",
    "email" => ":attribute एक वैध ईमेल पता होना चाहिए|",
    "exists" => ":attribute नहीं मिला है|",
    "min" => ":attribute कम से कम :min लंबा होना चाहिए|",
    "max" => ":attribute ज्यादा से ज्यादा :max लंबा होना चाहिए|",
    "in" => ":attribute एक वैध मान होना चाहिए|",
    "integer" => ":attribute एक अंक होना चाहिए|",
    "string" => ":attribute एक स्ट्रिंग होना चाहिए|",
];