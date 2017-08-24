<?php

    namespace Application\Enum;

    abstract class ApplicationType {
        
        const APPLICATION_FORM_URLENCODED = "application/x-www-form-urlencoded";
        const APPLICATION_JSON = "application/json";
        const APPLICATION_XML = "application/xml";
        const MULTIPART_FORM_DATA = "multipart/form-data";
        const TEXT_PLAIN = "text/plain";
        const TEXT_HTML = "text/html";
    }