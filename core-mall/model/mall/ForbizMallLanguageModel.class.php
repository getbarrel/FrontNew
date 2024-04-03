<?php

/**
 * Description of ForbizMallLanguageModel
 *
 * @author hong
 */
class ForbizMallLanguageModel extends ForbizModel
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 언어 타입 조회
     * @param boolean $use_disp
     * @return array
     */
    public function getLanguageType($use_disp = false)
    {
        if ($use_disp) {
            $this->qb->where('disp', 1);
        }

        return $this->qb
            ->select('language_name')
            ->select('language_code')
            ->from(TBL_GLOBAL_LANGUAGE)
            ->exec()
            ->getResultArray();
    }

    public function existsTransIx($trans_ix)
    {
        return $this->qb
                ->from(TBL_GLOBAL_TRANSLATION_DETAIL)
                ->where('trans_ix', $trans_ix)
                ->getCount() > 0;
    }

    /**
     * 번역문구 추가
     * @param array $data
     * @return string
     */
    public function addTranLang($trans_key, $text_korea)
    {
        if ($this->existsTransKey($trans_key) === false) {
            $reg_date = date('Y-m-d H:i:s');
            $trans_ix = $this->qb
                ->set('trans_key', $trans_key)
                ->set('text_name', $text_korea)
                ->set('text_korea', $text_korea)
                ->set('view_type', 'F')// 프론트
                ->set('regdate', $reg_date)
                ->insert(TBL_GLOBAL_TRANSLATION)
                ->exec();

            if ($this->existsTransIx($trans_ix) === false) {
                foreach ($this->getLanguageType(true) as $langType) {
                    if ($langType['language_code'] != 'korean') {
                        $text_korea = '(' . $langType['language_code'] . ')' . $text_korea;
                    }
                    $this->qb
                        ->set('trans_type', $langType['language_code'])
                        ->set('trans_text', $text_korea)
                        ->set('trans_ix', $trans_ix)
                        ->set('trans_key', $trans_key)
                        ->set('regdate', $reg_date)
                        ->insert(TBL_GLOBAL_TRANSLATION_DETAIL)
                        ->exec();
                }
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * 등록된 기준단어인지 확인
     * @param string $trans_key
     * @return boolean
     */
    public function existsTransKey($trans_key)
    {
        return $this->qb
                ->where('trans_key', $trans_key)
                ->where('view_type', 'F')// 프론트 전용
                ->from(TBL_GLOBAL_TRANSLATION)
                ->getCount() > 0;
    }
}