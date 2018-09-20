<?php
namespace frontend\controllers; 

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\helpers\Url;
use frontend\models\Search;
use yii\data\Pagination;
use yii\db\Query;

class SearchController extends Controller {

    private $limit = 5;

	public function beforeAction($action) { 
		return true;
	}
	
    /**
     * @ Function Name		: actionSearchGuide
     * @ Function Params	: NA 
     * @ Function Purpose 	: default index function that will be called to display search result 
     * @ Function Returns	: render view
     */
    public function actionSearchGuide() {
		
        $model = new Search();
        $queryParams = Yii::$app->request->queryParams;
        $limit = $this->limit;
        $dataArray = array('model' => $model,'searchResult' => [], 'searchString' => '', 'pages' => null);
        
        $searchfor = array();
        $searchString = '';
        
        if (!Yii::$app->request->isPost && empty($queryParams)) {
			$searchfor = Yii::$app->session->get('searchpost');
			
			//Yii::$app->session->remove('search_where');
			//Yii::$app->session->remove('searchWhere');
			//Yii::$app->session->remove('searchpost');
            //return $this->redirect(['site/home']);
            
		}else if(Yii::$app->request->isPost){
		
			$post = Yii::$app->request->post();
			Yii::$app->session->set('travellers', $post['Search']['travellers']);
			
			if(!empty($post)) {
				$post['Search']['searchdate'] = date('Y-m-d',strtotime($post['Search']['searchdate']));
				$searchfor = $post['Search'];
				Yii::$app->session->set('searchpost', $searchfor);
				
			}
			if (!($model->load($post) && $model->validate())) {
			   
				$errors = $model->errors;
				if(isset($errors['search_destination']))	
					Yii::$app->session->setFlash('item', Yii::t('yii','Please select a destination.'));
				else if(isset($errors['searchdate']))
					Yii::$app->session->setFlash('item', $errors['searchdate'][0]);	
					
				Yii::$app->session->remove('search_where');
				Yii::$app->session->remove('searchWhere');
				Yii::$app->session->remove('searchpost');
				$searchfor = array();
			}
			
		}
		
        
		if(!empty($searchfor)):
			//print_r($searchfor); exit();
			$searchDestination['destination'] = $searchfor['search_destination'];
            $WHERE = "user.status = '1' AND user.usrType = 'Member'";
            if(Yii::$app->user->identity !== null) {
				$loggedUserId =Yii::$app->user->identity->id;
				$WHERE .= " AND user.id != $loggedUserId";
			}
			if(isset($searchfor['interests']) && $searchfor['interests'] != "") {
				//$WHERE .= " AND user.usrInterests IN(".$searchfor['interests'].")";
				$WHERE .= " AND (user.usrInterests LIKE '%,$searchfor[interests]%' || user.usrInterests LIKE '%$searchfor[interests],%')";
			}
			
            if (trim($searchfor['city']) != '') {
                $searchString = preg_replace('/[^A-Za-z0-9\-]/', '', $searchfor['city']);
                $searchDestination['city'] = $searchfor['city'];
                $WHERE .= " AND services.cities LIKE '%$searchString%'";
            } elseif (trim($searchfor['state']) != '') {
                $searchString = preg_replace('/[^A-Za-z0-9\-]/', '', $searchfor['state']);
                $searchDestination['state'] = $searchfor['state'];
                $WHERE .= " AND services.states LIKE '%$searchString%'";
            } elseif (trim($searchfor['country_sortname']) != '') {
                $searchString = preg_replace('/[^A-Za-z0-9\-]/', '', $searchfor['country_sortname']);
                $WHERE .= " AND services.country_sortname LIKE '%$searchString%'";
            }
            Yii::$app->session->set('search_where', $WHERE);
           
            if (trim($searchfor['country']) != '') {
				 $searchDestination['country'] = $searchfor['country'];
			}
			$searchDestination['searchString'] = $searchString;
			Yii::$app->session->set('searchDestination', $searchDestination);
            
            if(!empty($searchfor['searchdate'])) {
				
				//$WHERE .= " AND (CAST('$searchfor[searchdate]' AS DATE) NOT BETWEEN booking.booked_from_date and booking.booked_to_date OR (CAST('$searchfor[searchdate]' AS DATE) BETWEEN booking.booked_from_date and booking.booked_to_date AND booking.booking_status = '0') OR booking.guyde_user_id IS null)";
				
				$WHERE .= " AND (user.id NOT IN(select guyde_user_id from booking  where CAST('$searchfor[searchdate]' AS DATE) BETWEEN booking.booked_from_date and booking.booked_to_date AND booking.booking_status = '1') OR booking.guyde_user_id IS null)";
				$searchdate = date('m/d/Y',strtotime($searchfor['searchdate']));
				$WHERE .= " AND ua.available_dates LIKE '%$searchdate%'";
			}
			$query = new Query;
            $query->select('user.*')
                    ->from('user')->distinct()
                    ->join('LEFT JOIN', 'guyde_services services', 'user.id = services.user_id')
                    ->join('LEFT OUTER JOIN', 'booking', 'user.id = booking.guyde_user_id')
                    ->join('LEFT JOIN', 'user_availability ua', 'user.id = ua.user_id')
                    ->where($WHERE);
            //echo $query->createCommand()->getRawSql(); die;      
			Yii::$app->session->set('searchWhere', $WHERE);
			
		endif;	
		
		// Pagination Query
		if (!Yii::$app->request->isPost && isset($queryParams['page']) && isset($queryParams['per-page'])) {
            $WHERE = Yii::$app->session->get('searchWhere');
			$query = new Query;
            $query->select('user.*')
                    ->from('user')->distinct()
                    ->join('LEFT JOIN', 'guyde_services services', 'user.id = services.user_id')
                    ->join('LEFT OUTER JOIN', 'booking', 'user.id = booking.guyde_user_id')
                    ->join('LEFT JOIN', 'user_availability ua', 'user.id = ua.user_id')
                    ->where($WHERE);
            
        }
      
        if(isset($query)) {
			$countQuery = clone $query;
			$pages = new Pagination(['totalCount' => $countQuery->count()]);
			
			$query->orderBy("user.usrDayPrice ASC")
				->offset($pages->offset)
				->limit($limit);    
			$searchResult = $query->createCommand()->queryAll();
			$pages->setPageSize($limit);
			###DYNAMICALLY BUILD THE DATA ARRAY TO PASS TO VIEW
			$dataArray = array_merge($dataArray, [            
				'searchResult' => $searchResult,
				'pages' => $pages,
				'searchString' => $searchString,
			]);
		
		}
        
        return $this->render('search-result-page', $dataArray);
    }
    
    
    /**
     * @ Function Name		: actionFilter
     * @ Function Params	: NA 
     * @ Function Purpose 	: filter search result 
     * @ Function Returns	: render view
     */
    public function actionFilter() {
		
        $queryParams = Yii::$app->request->queryParams;
        $limit = $this->limit;
        $dataArray = array('searchResult' => [],'pages' => null);
        $orderBy = "user.usrDayPrice ASC";
        $post = Yii::$app->request->post();
        if(!empty($post)) {
			$searchFilter = $post['filter'];
		
			$WHERE = "";
			$WHERE .= Yii::$app->session->get('search_where');
            
            if(isset($searchFilter['interest']) && !empty($searchFilter['interest'])) {
				$WHERE .= " AND (user.usrInterests LIKE '%,$searchFilter[interest]%' || user.usrInterests LIKE '%$searchFilter[interest],%')";
			}
			####= 01-12-2016 =####
            if(isset($searchFilter['language']) && !empty($searchFilter['language'])) {
				$WHERE .= " AND (user.usrLanguage LIKE '%$searchFilter[language]%')";
			}				
			
            if(isset($searchFilter['price'])) {
				if($searchFilter['price']=='D')
					$orderBy = "user.usrDayPrice DESC";
				elseif($searchFilter['price']=='A')
					$orderBy = "user.usrDayPrice ASC";
					
			}
			
			if(isset($searchFilter['date']) && !empty($searchFilter['date'])) {
				$filterDate = $searchFilter['date'];
				$filterDate = date('Y-m-d',strtotime($filterDate));
				// OR booking.guyde_user_id IS null
				$searchpost = Yii::$app->session->get('searchpost');
				$searchpost['searchdate'] = $filterDate;
				Yii::$app->session->set('searchpost', $searchpost);
				
				if(isset($searchFilter['days'])) {
					$filterDays = $searchFilter['days'];
					
					$toDate = date('Y-m-d',strtotime("+$filterDays days", strtotime($filterDate)));
					
					//$WHERE .= " AND (booking.booked_from_date NOT BETWEEN CAST('$filterDate' AS DATE) and CAST('$toDate' AS DATE) AND booking.booked_to_date NOT BETWEEN CAST('$filterDate' AS DATE) and CAST('$toDate' AS DATE) OR booking.guyde_user_id IS null)";
				
					$WHERE .= " AND (user.id NOT IN(select guyde_user_id from booking  where (booked_from_date BETWEEN CAST('$filterDate' AS DATE) and CAST('$toDate' AS DATE) OR booked_to_date BETWEEN CAST('$filterDate' AS DATE) and CAST('$toDate' AS DATE)) AND booking_status = '1') OR booking.guyde_user_id IS null)";
					
				}else{
					//$WHERE .= " AND (CAST('$filterDate' AS DATE) NOT BETWEEN booking.booked_from_date and booking.booked_to_date OR (CAST('$filterDate' AS DATE) BETWEEN booking.booked_from_date and booking.booked_to_date AND booking.booking_status = '0') OR booking.guyde_user_id IS null)";
					
					$WHERE .= " AND (user.id NOT IN(select guyde_user_id from booking  where CAST('$filterDate' AS DATE) BETWEEN booking.booked_from_date and booking.booked_to_date AND booking.booking_status = '1') OR booking.guyde_user_id IS null)";
					
				}
				$searchdate = date('m/d/Y',strtotime($filterDate));
				$WHERE .= " AND ua.available_dates LIKE '%$searchdate%'";
			}
			
			if(isset($searchFilter['time']) && $searchFilter['time'] !='ANY') {
				$WHERE .= " AND (ua.available_time = '$searchFilter[time]' || ua.available_time = 'ANY')";
			}
			$query = new Query;
            $query->select('user.*')
                    ->from('user')->distinct()
                    ->join('LEFT JOIN', 'guyde_services services', 'user.id = services.user_id')
                    ->join('LEFT JOIN', 'user_availability ua', 'user.id = ua.user_id')
                    ->join('LEFT OUTER JOIN', 'booking', 'user.id = booking.guyde_user_id')
                    ->where($WHERE);
         
           Yii::$app->session->set('filterWhere', $WHERE);
          
        }
        
        if (!Yii::$app->request->isPost && isset($queryParams['page']) && isset($queryParams['per-page'])) {
			
			$WHERE = Yii::$app->session->get('filterWhere');
			$query = new Query;
            $query->select('user.*')
                    ->from('user')->distinct()
                    ->join('LEFT JOIN', 'guyde_services services', 'user.id = services.user_id')
                    ->join('LEFT JOIN', 'user_availability ua', 'user.id = ua.user_id')
                    ->join('LEFT OUTER JOIN', 'booking', 'user.id = booking.guyde_user_id')
                    ->where($WHERE);
            
        }
        
        if(isset($query)) {
			
			$countQuery = clone $query;
			$pages = new Pagination(['totalCount' => $countQuery->count()]);
			$pages->setPageSize($limit);
		
			$query->offset($pages->offset)
			->orderBy($orderBy)
			->limit($limit);     
			$searchResult = $query->createCommand()->queryAll();
			
			###DYNAMICALLY BUILD THE DATA ARRAY TO PASS TO VIEW
			$dataArray = array_merge($dataArray, [            
				'searchResult' => $searchResult,
				'pages' => $pages,
			]);
		}
			
        $this->layout = false;      
        return $this->render('result', $dataArray);
    }
    

}
