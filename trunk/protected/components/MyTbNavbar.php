<?php

Yii::import('bootstrap.widgets.TbNavbar');

class MyTbNavbar extends TbNavbar
{
    	public function run()
	{
		echo CHtml::openTag('div', $this->htmlOptions);
		echo '<div class="Mynavbar-inner"><div class="'.$this->getContainerCssClass().'">';

		$collapseId = TbCollapse::getNextContainerId();

		if ($this->collapse !== false)
		{
			echo '<a class="btn btn-navbar" data-toggle="collapse" data-target="#'.$collapseId.'">';
			echo '<span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>';
			echo '</a>';
		}

		if ($this->brand !== false)
		{
			if ($this->brandUrl !== false)
				echo CHtml::openTag('a', $this->brandOptions).$this->brand.'</a>';
			else
			{
				unset($this->brandOptions['href']); // spans cannot have a href attribute
				echo CHtml::openTag('span', $this->brandOptions).$this->brand.'</span>';
			}
		}

		if ($this->collapse !== false)
		{
			$this->controller->beginWidget('bootstrap.widgets.TbCollapse', array(
				'id'=>$collapseId,
				'toggle'=>false, // navbars should be collapsed by default
				'htmlOptions'=>array('class'=>'nav-collapse'),
			));
		}

		foreach ($this->items as $item)
		{
			if (is_string($item))
				echo $item;
			else
			{
				if (isset($item['class']))
				{
					$className = $item['class'];
					unset($item['class']);

					$this->controller->widget($className, $item);
				}
			}
		}

		if ($this->collapse !== false)
			$this->controller->endWidget();

		echo '</div></div></div>';
	}
}
?>
