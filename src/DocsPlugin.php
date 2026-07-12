<?php

declare(strict_types=1);

namespace Magna\Docs;

use Magna\Contracts\RegistersAdminResources;
use Magna\Contracts\RegistersDashboardWidgets;
use Magna\Contracts\RegistersSettingsPages;
use Magna\Docs\Filament\Pages\DocsSettingsPage;
use Magna\Docs\Filament\Resources\DocCollectionResource;
use Magna\Docs\Filament\Resources\DocPageResource;
use Magna\Docs\Filament\Widgets\DocsStatsWidget;
use Magna\Plugins\Plugin;

class DocsPlugin extends Plugin implements RegistersAdminResources, RegistersDashboardWidgets, RegistersSettingsPages
{
    /** @return list<class-string> */
    public function dashboardWidgets(): array
    {
        return [DocsStatsWidget::class];
    }

    public function boot(): void
    {
        $this->app['view']->addNamespace('docs', $this->basePath.'/resources/views');

        $this->app['router']->middleware('web')->group(function (): void {
            require $this->routesPath('web.php');
        });
    }

    public function adminResources(): array
    {
        return [
            DocCollectionResource::class,
            DocPageResource::class,
        ];
    }

    /**
     * Returns the Filament page classes that should be registered in the admin
     * panel. AdminPanelProvider calls this via resolvePluginPages().
     * The Settings button in the Installed Plugins page links to settingsPages()[0].
     *
     * @return list<class-string>
     */
    public function settingsPages(): array
    {
        return [DocsSettingsPage::class];
    }
}
