<?php

/**
 * Description of ForbizMallTriggerModel
 *
 * @author hong
 */
class ForbizMallTriggerModel extends ForbizModel
{

    /**
     * 메일&SMS 처리
     * @param type $mcCode
     * @return type
     */
    public function getMsgConfig($mcCode)
    {
        return $this->qb
                ->select('mc_ix')
                ->select('mc_mail_title')
                ->select('mc_mail_usersend_yn')
                ->select('mc_sms_usersend_yn')
                ->select('kakao_alim_talk_template_code')
                ->from(TBL_SHOP_MAILSEND_CONFIG)
                ->where('mc_code', $mcCode)
                ->exec()->getRow();
    }

    /**
     * 이메일 전송시 사용될 템플릿 전역 데이타
     * @return array
     */
    public function getCommonEmailTemplateData()
    {
        return [
            'mallDomain' => HTTP_PROTOCOL.FORBIZ_HOST
            , 'templateImagePath' => HTTP_PROTOCOL.FORBIZ_HOST . '/assets/templet/' . MALL_TEMPLATE . '/images'
            , 'dataImagePath' => (!empty(IMAGE_SERVER_DOMAIN) ? IMAGE_SERVER_DOMAIN : HTTP_PROTOCOL . FORBIZ_HOST ) . MALL_DATA . '/images'
            , 'mallName' => ForbizConfig::getCompanyInfo('shop_name')
            , 'comName' => ForbizConfig::getCompanyInfo('com_name')
            , 'comCeo' => ForbizConfig::getCompanyInfo('com_ceo')
            , 'comAddr1' => ForbizConfig::getCompanyInfo('com_addr1')
            , 'comAddr2' => ForbizConfig::getCompanyInfo('com_addr2')
            , 'comEmail' => ForbizConfig::getCompanyInfo('com_email')
            , 'comNumber' => ForbizConfig::getCompanyInfo('com_number')
            , 'comCsPhone' => ForbizConfig::getCompanyInfo('cs_phone')
            , 'comOnlineBusinessNumber' => ForbizConfig::getCompanyInfo('online_business_number')
            , 'comOfficerName' => ForbizConfig::getCompanyInfo('officer_name')
        ];
    }
}
