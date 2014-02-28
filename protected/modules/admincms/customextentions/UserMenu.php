<?php
Yii::import('zii.widgets.CMenu');
 
class UserMenu extends CMenu
{
	public $activateItems=true;
    //need to include this for our function to run
	
    public function run()
    {
        $this->renderMenu($this->items);
    }
	
	protected function renderMenu($items)
	{
		if(count($items))
		{	
			echo "<div id=\"left_nav\">";
			echo "<div class=\"left_nav_top\"></div>";
			echo CHtml::openTag('ul',$this->htmlOptions)."\n";
			$this->renderMenuRecursive($items);
			echo CHtml::closeTag('ul');
			echo "<div class=\"left_nav_bottom\" ></div>";
			echo "</div>";
			
		}
	}
 
   
	protected function renderMenuRecursive($items)
	{
		$count=0;
		$n=count($items);
		foreach($items as $item)
		{
			$count++;
			$options=isset($item['itemOptions']) ? $item['itemOptions'] : array();
			$class=array();
			if($item['active'] && $this->activeCssClass!='')
				$class[]=$this->activeCssClass;
			if($count===1 && $this->firstItemCssClass!='')
				$class[]=$this->firstItemCssClass;
			if($count===$n && $this->lastItemCssClass!='')
				$class[]=$this->lastItemCssClass;
			if($class!==array())
			{
				if(empty($options['class']))
					$options['class']=implode(' ',$class);
				else
					$options['class'].=' '.implode(' ',$class);
			}
			echo CHtml::openTag('li', $options);

			$menu=$this->renderMenuItem($item);
			if(isset($this->itemTemplate) || isset($item['template']))
			{
				$template=isset($item['template']) ? $item['template'] : $this->itemTemplate;
				echo strtr($template,array('{menu}'=>$menu));
				
			}
			else {
				echo $menu;
			}

			if(isset($item['items']) && count($item['items']))
			{
				echo "\n".CHtml::openTag('ul',isset($item['submenuOptions']) ? $item['submenuOptions'] : $this->submenuHtmlOptions)."\n";
				$this->renderMenuRecursive($item['items']);
				echo $item['items'];
				echo CHtml::closeTag('ul')."\n";
			}

			echo CHtml::closeTag('li')."\n";
			
			
		}
	} 
}
?>