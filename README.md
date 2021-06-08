# validator
OO validator


Example:
```php
        return $validation
            ->parameter(function(ValidationParameter $parameter) {
                $parameter
                    ->name('age')
                    ->required()
                    ->sanitizer(IntegerSanitizer::class)
                    ->sanitizer(SomeOtherSanitizer::class)
                    ->validator(AgeValidator::class)
                    ->depends(function(ValidationDependency $dependency) {
                        $dependency
                            ->must('password')
                            ->mustNot('facebook_id');
                    });
            })
            ->parameter(function(ValidationParameter $parameter) {
                $parameter
                    ->name('password')
                    ->required()
                    ->default('Gabbals')
                    ->validator(UsernameValidator::class);
            })
            ->parameter(function(ValidationParameter $parameter) {
                $parameter
                    ->name('facebook_id')
                    ->required()
                    ->default('Facebook Gabbals')
                    ->validator(FacebookIdValidator::class)
                    ->depends(function(ValidationDependency $dependency) {
                        $dependency
                            ->mustNot('username');
                    });
            })
```
            
			
DEPENDENCY EXAMPLES

```php
            ->parameter(function(ValidationParameter $parameter) {
                $parameter
                    ->name('one_or')
                    ->depends(function(ValidationDependency $dependency) {
                        $dependency->orRequire('two_or');
                    })
                    ->validator(NonEmptyStringValidator::class)
                    ->castTo(TypeString::class);
            })
            ->parameter(function(ValidationParameter $parameter) {
                $parameter
                    ->name('two_or')
                    ->depends(function(ValidationDependency $dependency) {
                        $dependency->orRequire('one_or');
                    })
                    ->validator(NonEmptyStringValidator::class)
                    ->castTo(TypeString::class);
            })
            
            ->parameter(function(ValidationParameter $parameter) {
                $parameter
                    ->name('one_must')
                    ->depends(function(ValidationDependency $dependency) {
                        $dependency->must('two_must');
                    })
                    ->validator(NonEmptyStringValidator::class)
                    ->castTo(TypeString::class);
            })
            ->parameter(function(ValidationParameter $parameter) {
                $parameter
                    ->name('two_must')
                    ->validator(AbuseReportTypeValidator::class)
                    ->castTo(TypeString::class);
            })
            
            ->parameter(function(ValidationParameter $parameter) {
                $parameter
                    ->name('one_must_not')
                    ->depends(function(NonEmptyStringValidator $dependency) {
                        $dependency->mustNot('two_must_not');
                    })
                    ->validator(AbuseReportTypeValidator::class)
                    ->castTo(TypeString::class);
            })
            ->parameter(function(ValidationParameter $parameter) {
                $parameter
                    ->name('two_must_not')
                    ->validator(NonEmptyStringValidator::class)
                    ->castTo(TypeString::class);
            });
```