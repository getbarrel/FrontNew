<?
/**
 * facebook 로그인 관련 컨트롤러
 * 
 * @author bgh
 * @date 2013.07.15
 * 
 */
include ($_SERVER["DOCUMENT_ROOT"].'/openapi/naverLogin/nalogin_m.php');

class nalogin{
    
    private $model = null;
    private $unique = null;
    
    public function __construct(){
        $this->model = new nalogin_m();
        $this->unique = null;
    }
    
    /**
     * 사이트에서 사용할 Short UniqueId 리턴
     * 
     * @return {string} usable uid
     */
    public function getUid(){
        do{
            $unique = $this->generate_random_letters(8);
            $check = $this->model->isUsableId($unique);
        }while(!$check);
        
        return $unique;
    }
    
    /**
     * UniqueId 생성
     * 
     * @param {int} length
     * @return {string} uid
     */
    private function generate_random_letters($length) {
        $random = '';
        for ($i = 0; $i < $length; $i++) {
            $random .= chr(rand(ord('a'), ord('z')));
        }
        return $random;
    }
    
    /**
     * 회원정보 입력
     * 
     * @param {array} member data
     * @return {boolean} T/F
     */
    private function forceJoin($data){
        return $this->model->insertUserInfo($data);
    }
    
    /**
     * 로그인 처리
     * 
     * @param {array} na receive data
     * @return {boolean} T/F
     */
    public function goLogin($data){
		/* 에이랜드는 네이버아이디와 쇼핑몰아이디를 별도로 쓰므로 주석 16.07.25 pys
        if(!$this->model->isInnaId($data["userID"])){
            $data["profile_img"] = $data["profImg"];
            //email id사용으로 인한 주석
            //$data["shopId"] = $this->getUid();
        
            $this->forceJoin($data);
        }
		*/
        $result = $this->model->naLoginProcess($data);
        
        if(!empty($result)){
			//세션은 login.php 에서 처리
			return true;
			/*
            if($this->model->insertLoginData($result["code"])){
                $result["perm"] = $result["gp_level"];
                $_SESSION["user"] = $result;
        
                return true;
            }else{
                return false;
            }
			*/
        }else{
            return false;
        }
    }

	/**
     * 인증된 아이디가 쇼핑몰에 등록된 아이디인치 체크
     * 
     * @param {array} na receive data
     * @return {boolean} T/F
     */

	 public function idDupCheck($id){
		return $this->model->idDupCheck($id);
	 }
}