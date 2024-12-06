<?php
use Services\Utils;
if (!empty($data['entity_data'])) : ?>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Jobs</th>
                <th>Birth_date</th>
                <th>Death_date</th>
                <th>Bio</th>
                <th>Genre</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['entity_data'] as $person) : 
                $person["jobs"] = Utils::getPersonJobs($person);
            ?>
                <tr data-name="<?= $person["full_name"] ?>">
                    <td><?= $person["full_name"] ?></td>
                    <td><?= implode(" & ", $person["jobs"]) ?></td>
                    <td><?= $person["birth_date"] ?></td>
                    <td><?= $person["death_date"] !== null ? $person["death_date"] : "Alive" ?></td>
                    <td class="field-truncate"><?= $person["bio"] !== null ? substr($person["bio"], 0, 100) : "None" ?></td>
                    <td><?= $person["genre"] ?></td>
                    <td>
                        <a class="action edit">Edit</a>
                        <a class="action delete">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>Aucun film trouvé.</p>
<?php endif; ?>
