<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Symfony\Component\Form\FormFactoryInterface;


class DataTablesExtension extends AbstractExtension
{

	public function __construct(FormFactoryInterface $formFactory)
	{
		$this->formFactory = $formFactory;
	}

	public function getFilters(): array
	{
		return [
			// If your filter generates SAFE HTML, you should add a third
			// parameter: ['is_safe' => ['html']]
			// Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
			// new TwigFilter('d', [$this, 'd']),
			// new TwigFilter('chart_data_convert', [$this, 'objectToData', ['is_safe' => ['html']]]),
		];
	}

	public function getFunctions(): array
	{
		return [
			new TwigFunction('get_simple_datatables_JS', [$this, 'getSimpleDataTablesJS'], ['is_safe' => ['html']]),
			//new TwigFunction('get_chart_radar_config', [$this, 'getRadarConfig'], ['is_safe' => ['html']]),
		];
	}


    public function getSimpleDataTablesJS($id = false)
    {
        if($id === false)
        {
            $id = 'table';
        }

            return 
            'var table = $("' . $id . '").DataTable({
                   dom: "Bfrtip",
                buttons: [
                    "copy", "excel"
                ],
                "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.22/i18n/French.json"
                },
                "field": {
                    "className" : "form-control bg-light border-0 small"
                }
            });';
    }

}
