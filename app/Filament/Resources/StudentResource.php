<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('due_date')->date()->sortable()->searchable(),
                //
            ])
            ->filters([
                Tables\Filters\Filter::make('due_date')
                    ->form([
                        Forms\Components\DatePicker::make('due_date_from')->label('Due Date From'),
                        Forms\Components\DatePicker::make('due_date_to')->label('Due Date To'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['due_date_from'], fn ($query, $date) => $query->whereDate('due_date', '>=', $date))
                            ->when($data['due_date_to'], fn ($query, $date) => $query->whereDate('due_date', '<=', $date));
                    }),
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                
            ])
            //custom csv import action
            ->headerActions([
                Tables\Actions\Action::make('import_csv')
                    ->label('Import CSV')
                    ->icon('heroicon-o-arrow-up-tray') // valid upload icon
                    ->form([
                        Forms\Components\FileUpload::make('csv_file')
                            ->label('CSV File')
                            ->required()
                            ->acceptedFileTypes(['text/csv', 'text/plain', '.csv']),
                    ])
                    ->action(function (array $data) {
                        if (isset($data['csv_file'])) {
                            $file = $data['csv_file'];
                            if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
                                while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                                    Student::create([
                                        'name' => $row[0],
                                        'email' => $row[1],
                                        'due_date' => $row[2],
                                    ]);
                                }
                                fclose($handle);
                            }
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
