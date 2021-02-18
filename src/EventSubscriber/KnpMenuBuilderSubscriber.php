<?php
// src/EventSubscriber/KnpMenuBuilderSubscriber.php
namespace App\EventSubscriber;

use KevinPapst\AdminLTEBundle\Event\KnpMenuEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class KnpMenuBuilderSubscriber implements EventSubscriberInterface
{

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    

    public static function getSubscribedEvents(): array
    {
        return [
            KnpMenuEvent::class => ['onSetupMenu', 100],
        ];
    }
    
    public function onSetupMenu(KnpMenuEvent $event)
    {
        $user = $this->container->get('security.authorization_checker');
        $menu = $event->getMenu();

        // TEACHER
        if($user->isGranted('ROLE_TEACHER'))
        {
            $menu->addChild('PROJETS', [
                'childOptions' => $event->getChildOptions()
            ])->setAttribute('class', 'header');
            
            $menu->addChild('Gérer', [
                'route' => 'teacher_projects_manage',
            ])->setLabelAttribute('icon', 'fas fa-cog');
    
    
            $menu->addChild('CORRECTIONS', [
                'childOptions' => $event->getChildOptions()
            ])->setAttribute('class', 'header');
            
            $menu->addChild('Évaluer', [
                'route' => 'teacher_assessments_list',
            ])->setLabelAttribute('icon', 'fas fa-pencil-alt');
    
            $menu->addChild('Encoder en masse', [
                'route' => 'teacher_manual_assess_list',
            ])->setLabelAttribute('icon', 'fas fa-marker');
    
    
            $menu->addChild('PRÉSENCES', [
                'childOptions' => $event->getChildOptions()
            ])->setAttribute('class', 'header');
            
            $menu->addChild('Encoder', [
                'route' => 'teacher_attendance_index',
            ])->setLabelAttribute('icon', 'fas fa-tasks');
    
            $menu->addChild('Statistiques', [
                'route' => 'teacher_attendance_statistics',
            ])->setLabelAttribute('icon', 'fas fa-chart-line');
    
            $menu->addChild('Carnet', [
                'route' => 'teacher_attendance_book',
            ])->setLabelAttribute('icon', 'fas fa-list');
    
    
            $menu->addChild('RÉSULTATS', [
                'childOptions' => $event->getChildOptions()
            ])->setAttribute('class', 'header');
            
            $menu->addChild('Cahier de cotes', [
                'route' => 'teacher_grade_book',
            ])->setLabelAttribute('icon', 'fas fa-table');
    
            $menu->addChild('Global élève', [
                'route' => 'teacher_results_detailled',
            ])->setLabelAttribute('icon', 'fas fa-chart-pie');
    
            $menu->addChild('Détaillés élève', [
                'route' => 'teacher_results_simplified',
            ])->setLabelAttribute('icon', 'fas fa-th-list');
    
    
            $menu->addChild('VUE D\'ENSEMBLE', [
                'childOptions' => $event->getChildOptions()
            ])->setAttribute('class', 'header');
            
            $menu->addChild('Trombinoscope', [
                'route' => 'teacher_users_gallery',
            ])->setLabelAttribute('icon', 'fas fa-id-card');
    
            $menu->addChild('Gallerie', [
                'route' => 'gallery',
            ])->setLabelAttribute('icon', 'fas fa-images');
    
    
            $menu->addChild('CONFIGURATION', [
                'childOptions' => $event->getChildOptions()
            ])->setAttribute('class', 'header');
            
            $menu->addChild('Compétences', [
                'route' => 'teacher_skills',
            ])->setLabelAttribute('icon', 'fas fa-graduation-cap');
            
            $menu->addChild('Système', [])->setLabelAttribute('icon', 'fas fa-cogs');
                
                $menu['Système']->addChild('Élèves', [
                        'route' => 'teacher_students',
                    ])->setLabelAttribute('icon', 'fas fa-user');
                
                $menu['Système']->addChild('Classes', [
                        'route' => 'classes_index',
                    ])->setLabelAttribute('icon', 'fas fa-users');
                
                $menu['Système']->addChild('Cours', [
                        'route' => 'courses_index',
                    ])->setLabelAttribute('icon', 'fas fa-suitcase');
        }
        // STUDENT
        elseif($user->isGranted('ROLE_STUDENT'))
        {
            $menu->addChild('PROJETS', [
                'childOptions' => $event->getChildOptions()
            ])->setAttribute('class', 'header');
            
            $menu->addChild('Remises', [
                'route' => 'student_submissions',
            ])->setLabelAttribute('icon', 'fas fa-file-upload');


            $menu->addChild('RÉSULTATS', [
                'childOptions' => $event->getChildOptions()
            ])->setAttribute('class', 'header');
            
            $menu->addChild('Globaux', [
                'route' => 'student_global_results',
            ])->setLabelAttribute('icon', 'fas fa-chart-pie');
            
            $menu->addChild('Par projet', [
                'route' => 'student_simplified_results',
            ])->setLabelAttribute('icon', 'fas fa-chart-bar');
        

            $menu->addChild('VUE D\'ENSEMBLE', [
                'childOptions' => $event->getChildOptions()
            ])->setAttribute('class', 'header');
            
            $menu->addChild('Trombinoscope', [
                'route' => 'student_users_gallery',
            ])->setLabelAttribute('icon', 'fas fa-id-card');
    
            $menu->addChild('Ma gallerie', [
                'route' => 'my_gallery',
            ])->setLabelAttribute('icon', 'fas fa-image');

            $menu->addChild('Gallerie publique', [
                'route' => 'gallery',
            ])->setLabelAttribute('icon', 'fas fa-images');

        }

    }
}