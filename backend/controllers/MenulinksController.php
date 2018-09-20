<?php

namespace backend\controllers;

use Yii;
use app\models\menu\Menulinks;
use app\models\menu\MenulinkSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\filters\AccessControl;
/**
 * MenulinksController implements the CRUD actions for Menulinks model.
 */
class MenulinksController extends Controller
{
    public function behaviors()
    {
        return [
			'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
						'actions' => ['index','create','delete','update','view','status','links'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],        
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Menulinks models.
     * @return mixed
     */
    public function actionIndex()
    {
			Yii::$app->response->redirect('menus')->send();				
    }
    
    /**
     * Lists all Menulinks models.
     * @return mixed
     */
    public function actionLinks($id=0)
    {	
        $searchModel = new MenulinkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->pagination->pageSize = (isset($_GET['p']) ? $_GET['p'] : PAGE_LIMIT);        
        return $this->render('index', [
				'dataProvider' => $dataProvider,
				'searchModel' => $searchModel,
				'menuID' => $id,
        ]);	
    }

    /**
     * Displays a single Menulinks model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		$modelLink = new Menulinks();
		$menu  = $modelLink->getMenuId($id);
		if(!isset($menu[0]['menu_id'])) {
			return $this->redirect(Yii::$app->homeUrl.'menus');
		}
		
        return $this->render('view', [
            'model' => $this->findModel($id),
            'menuID' => $menu[0]['menu_id'],
        ]);
    }

    /**
     * Creates a new Menulinks model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($mId=0)
    {
			$parm = Yii::$app->request->queryParams;
			if(isset($parm['id']) && !empty($parm['id'])) {
			   $id = $parm['id'];
			   $model = new Menulinks();
			   if ($model->load(Yii::$app->request->post())) {

				$model->menu_id 		= (isset($_POST['Menulinks']['menu_id']) ? $_POST['Menulinks']['menu_id'] : 0 );
				$model->title 			= (isset($_POST['Menulinks']['title']) ? $_POST['Menulinks']['title'] : 0 );
				
				if(isset($_POST['Menulinks']['Type']) && $_POST['Menulinks']['Type'] == 1) {
					$model->parent_page_id  = (isset($_POST['Menulinks']['customURL']) ? $_POST['Menulinks']['customURL'] : 0 );
					$model->page_id 		= 0;
					$model->menuType 		= 'Url';
					$model->menuUrl 		= (isset($_POST['Menulinks']['Custom']) ? $_POST['Menulinks']['Custom'] : 0 );

					
					if(empty($model->menuUrl) || $model->menuUrl == '') {
						$data['respmesg'] = "Custom Url cannot be blank.";
						$data['class'] = "alert-danger";	
						$list  = $model->getPagesList();
						$plist  = $model->getPageParentList();
						return $this->render('create', [
							'model' => $model,
							'list' => $list,
							'plist' => $plist,
							'data' => $data,
							'menuID' => $id,
						]);  											
					}
										
				} else if(isset($_POST['Menulinks']['Type']) && $_POST['Menulinks']['Type'] == 2) {
					$model->parent_page_id  = (isset($_POST['Menulinks']['customPage']) ? $_POST['Menulinks']['customPage'] : 0 );
					$model->page_id 		= (isset($_POST['Menulinks']['Page']) ? $_POST['Menulinks']['Page'] : 0 );
					$model->menuType 		= 'Page';
					$model->menuUrl 		= '';
				} else {
					$model->parent_page_id = 0;
					$model->menuType 		= 'Page';
					$model->page_id 		= (isset($_POST['Menulinks']['Page']) ? $_POST['Menulinks']['Page'] : 0 );
					$model->menuUrl 		= (isset($_POST['Menulinks']['Custom']) ? $_POST['Menulinks']['Custom'] : 0 );
				}
				
				if(empty($model->parent_page_id) || $model->parent_page_id == '' || $model->parent_page_id == 'Null') {
					$model->parent_page_id = 0;
				}
				
				$model->sort_order 		= 1;
				$model->dateCreated 	= date('Y-m-d h:m:s');
				if($model->save()) {
					$data['respmesg'] = "Menu item has been saved successfully!";
					$data['class'] = "alert-success";
					Yii::$app->session->setFlash('item', 'Menu item has been saved successfully!');
					return $this->redirect(array('links', 'id' => $id));				
				} else {
					$data['respmesg'] = "Please enter valid values for all the fields!";
					$data['class'] = "alert-danger";			
				}
				$list  = $model->getPagesList();
				$plist  = $model->getPageParentList();
				return $this->render('create', [
					'model' => $model,
					'list' => $list,
					'plist' => $plist,
					'data' => $data,
					'menuID' => $id,
				]);            
				
			} else {
				
				$list  = $model->getPagesList();
				$plist  = $model->getPageParentList();
				return $this->render('create', [
					'model' => $model,
					'list' => $list,
					'plist' => $plist,
					'menuID' => $id,
				]);
				
			}
		 } else {
			return $this->redirect('../menus/index');
		}
    }

    /**
     * Updates an existing Menulinks model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

		$modelLink = new Menulinks();
		$menu  = $modelLink->getMenuId($id);
		if(!isset($menu[0]['menu_id'])) {
			$this->redirect(Yii::$app->homeUrl.'menus');
		}
		
        if ($model->load(Yii::$app->request->post())) {
			
				$model->menu_id 		= (isset($_POST['Menulinks']['menu_id']) ? $_POST['Menulinks']['menu_id'] : 0 );
				$model->title 			= (isset($_POST['Menulinks']['title']) ? $_POST['Menulinks']['title'] : 0 );
				
				if(isset($_POST['Menulinks']['Type']) && $_POST['Menulinks']['Type'] == 1) {
					$model->parent_page_id  = (isset($_POST['Menulinks']['customURL']) ? $_POST['Menulinks']['customURL'] : 0 );
					$model->page_id 		= 0;
					$model->menuType 		= 'Url';
					$model->menuUrl 		= (isset($_POST['Menulinks']['Custom']) ? $_POST['Menulinks']['Custom'] : 0 );

					
					if(empty($model->menuUrl) || $model->menuUrl == '') {
						$data['respmesg'] = "Custom Url cannot be blank.";
						$data['class'] = "alert-danger";	
						$list  = $model->getPagesList();
						$plist  = $model->getPageParentList();
						return $this->render('create', [
							'model' => $model,
							'list' => $list,
							'plist' => $plist,
							'data' => $data,
							'menuID' => $menu[0]['menu_id'],
						]);  											
					}
										
				} else if(isset($_POST['Menulinks']['Type']) && $_POST['Menulinks']['Type'] == 2) {
					$model->parent_page_id  = (isset($_POST['Menulinks']['customPage']) ? $_POST['Menulinks']['customPage'] : 0 );
					$model->page_id 		= (isset($_POST['Menulinks']['Page']) ? $_POST['Menulinks']['Page'] : 0 );
					$model->menuType 		= 'Page';
					$model->menuUrl 		= '';
				} else {
					$model->parent_page_id = 0;
					$model->menuType 		= 'Page';
					$model->page_id 		= (isset($_POST['Menulinks']['Page']) ? $_POST['Menulinks']['Page'] : 0 );
					$model->menuUrl 		= (isset($_POST['Menulinks']['Custom']) ? $_POST['Menulinks']['Custom'] : 0 );
				}
				
				if(empty($model->parent_page_id) || $model->parent_page_id == '' || $model->parent_page_id == 'Null') {
					$model->parent_page_id = 0;
				}
				
				$model->sort_order 		= 1;
				$model->dateCreated 	= date('Y-m-d h:m:s');
				if($model->save()) {
					$data['respmesg'] = "Menu item has been updated successfully!";
					$data['class'] = "alert-success";
					Yii::$app->session->setFlash('item', 'Menu item has been updated successfully!');
					return $this->redirect(array('links', 'id' => $model->menu_id));					
				} else {
					$data['respmesg'] = "Please enter valid values for all the fields!";
					$data['class'] = "alert-danger";			
				}
				$list  = $model->getPagesList();
				$plist  = $model->getPageParentList();
				return $this->render('create', [
					'model' => $model,
					'list' => $list,
					'plist' => $plist,
					'data' => $data,
					'menuID' => $menu[0]['menu_id'],
				]);  
        } else {

				$list  = $model->getPagesList();
				$plist  = $model->getPageParentList();
				return $this->render('update', [
					'model' => $model,
					'list' => $list,
					'plist' => $plist,
					'menuID' => $menu[0]['menu_id'],
				]);     			

			}
    }

    /**
     * Deletes an existing Menulinks model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		
		$modelLink = new Menulinks();
		$menu  = $modelLink->getMenuId($id);
		if(!isset($menu[0]['menu_id'])) {
			return $this->redirect(Yii::$app->homeUrl.'menus'); exit();
		}
				
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('item', 'Selected menu item deleted successully!');
        return $this->redirect(['menulinks/links/'. $menu[0]['menu_id']]);
    }

    /**
     * Finds the Menulinks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menulinks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menulinks::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
			
}
