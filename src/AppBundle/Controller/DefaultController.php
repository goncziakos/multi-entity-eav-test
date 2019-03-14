<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Order;
use Sidus\EAVModelBundle\Context\ContextManagerInterface;
use Sidus\EAVModelBundle\Model\Family;
use Sidus\EAVModelBundle\Registry\AttributeRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sidus\EAVModelBundle\Registry\FamilyRegistry;
use Sidus\EAVModelBundle\Form\Type\DataType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        /** @var FamilyRegistry $familyRegistry */
        $familyRegistry = $this->get(FamilyRegistry::class);

        $config = [
            'data_class' => 'AppBundle\Entity\Order',
            'value_class' => 'AppBundle\Entity\OrderAttributeValue',
            'attributeAsLabel' => 'title',
            'attributes' => [
                'title' => [
                    'required' => true,
                ]
            ]
        ];

        /** @var AttributeRegistry $attributeRegistry */
        $attributeRegistry = $this->get(AttributeRegistry::class);
        /** @var ContextManagerInterface $contextManager */
        $contextManager = $this->get(ContextManagerInterface::class);

        $family = new Family(
            'Order',
            $attributeRegistry,
            $familyRegistry,
            $contextManager,
            $config
        );

        $familyRegistry->addFamily($family);


        $familyRegistry = $this->get(FamilyRegistry::class);
        dump($familyRegistry);


        $postFamily = $familyRegistry->getFamily('Order');

        $newPost = $postFamily->createData();
        $newPost->setTitle('New Order');
        //echo $newPost->getTitle();

        /** @var Form $form */
        $form = $this->createForm(DataType::class, $newPost, [
            'family' => 'Order',
        ]);

        $form->setData($newPost);

        $form->add('save', SubmitType::class, ['label' => 'Save']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order = $form->getData();
            dump($order);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($order);
            $entityManager->flush();

        }
        /**
         * @var \Doctrine\ORM\EntityManagerInterface $entityManager
         * @var \Sidus\EAVModelBundle\Entity\DataInterface $data
         */
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/invoice", name="invoice")
     */
    public function invoiceAction(Request $request)
    {

        /** @var FamilyRegistry $familyRegistry */
        $familyRegistry = $this->get(FamilyRegistry::class);

        $postFamily = $familyRegistry->getFamily('Invoice');

        $newPost = $postFamily->createData();
        $newPost->setTitle('New Invoice');
        //echo $newPost->getTitle();

        /** @var Form $form */
        $form = $this->createForm(DataType::class, $newPost, [
            'family' => 'Invoice',
        ]);

        $form->setData($newPost);

        $form->add('save', SubmitType::class, ['label' => 'Save']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order = $form->getData();
            dump($order);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($order);
            $entityManager->flush();

        }
        /**
         * @var \Doctrine\ORM\EntityManagerInterface $entityManager
         * @var \Sidus\EAVModelBundle\Entity\DataInterface $data
         */
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
            'form' => $form->createView(),
        ]);
    }
}
