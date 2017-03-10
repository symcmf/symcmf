<?php
namespace Application\Sonata\UserBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;

class UserAdmin extends \Sonata\UserBundle\Admin\Model\UserAdmin {

    protected function configureFormFields(FormMapper $formMapper)
    {
        // define group zoning
        $formMapper
            ->tab('User')
            ->with('Profile', ['class' => 'col-md-6'])->end()
            ->with('General', ['class' => 'col-md-6'])->end()
            ->with('Social', ['class' => 'col-md-6'])->end()
            ->end()
            ->tab('Security')
            ->with('Status', ['class' => 'col-md-4'])->end()
            ->with('Groups', ['class' => 'col-md-4'])->end()
            ->with('Keys', ['class' => 'col-md-4'])->end()
            ->with('Roles', ['class' => 'col-md-12'])->end()
            ->end()
        ;

        $now = new \DateTime();

        $formMapper
            ->tab('User')
            ->with('General')
            ->add('username')
            ->add('email')
            ->add('plainPassword', 'text', [
                'required' => (!$this->getSubject() || is_null($this->getSubject()->getId())),
            ])
            ->end()
            ->with('Profile')
            ->add('dateOfBirth', 'sonata_type_date_picker', [
                'years' => range(1900, $now->format('Y')),
                'dp_min_date' => '1-1-1900',
                'dp_max_date' => $now->format('c'),
                'required' => false,
            ])
            ->add('firstname', null, ['required' => false])
            ->add('lastname', null, ['required' => false])
            ->add('website', 'url', ['required' => false])
            ->add('biography', 'text', ['required' => false])
            ->add('gender', 'sonata_user_gender', [
                'required' => true,
                'translation_domain' => $this->getTranslationDomain(),
            ])
            ->add('locale', 'locale', ['required' => false])
            ->add('timezone', 'timezone', ['required' => false])
            ->add('phone', null, ['required' => false])
            ->end()
            ->with('Social')
            ->add('facebookId', null, ['required' => false, 'label' => 'Facebook id'])
            ->add('googleId', null, ['required' => false, 'label' => 'Google id'])
            ->end()
            ->end()
            ->tab('Security')
            ->with('Status')
            ->add('locked', null, ['required' => false])
            ->add('expired', null, ['required' => false])
            ->add('enabled', null, ['required' => false])
            ->add('credentialsExpired', null, ['required' => false])
            ->end()
            ->with('Groups')
            ->add('groups', 'sonata_type_model', [
                'required' => false,
                'expanded' => true,
                'multiple' => true,
            ])
            ->end()
            ->with('Roles')
            ->add('realRoles', 'sonata_security_roles', [
                'label' => 'form.label_roles',
                'expanded' => true,
                'multiple' => true,
                'required' => false,
            ])
            ->end()
            ->with('Keys')
            ->add('token', null, ['required' => false])
            ->add('twoStepVerificationCode', null, ['required' => false])
            ->end()
            ->end()
        ;
    }
}
